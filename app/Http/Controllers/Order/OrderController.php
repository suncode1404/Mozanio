<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Setting\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Cart\CartController;
use App\Models\Cart\Cart;
use App\Models\Order\OrderDetails;
use App\Models\Cart\CartItem;
use App\Models\Cart\CartItemAddOn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Promotion;
use App\Models\User\User;
use App\Utils\Message;
use App\Utils\UnixConverter;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    protected $admin;
    /**
     * Display a listing of the resource.
     */
    public  function __construct(Request $request)
    {
        $this->admin = $request->session()->get('isAdmin');
        View::share('admin',  $this->admin);
    }
    public function index()
    {
        if ($this->admin->role_id >= 2) {
            $orders = Order::with(['deliveryMethod', 'payment', 'product'])->orderBy("date_created", "desc")->whereNull("vender_id")->get();
            return view("admin.order.list", compact("orders"));
        }
        $orders = Order::with(['deliveryMethod', 'payment', 'product'])->orderBy("date_created", "desc")->get();
        return view("admin.order.list", compact("orders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusId = Status::all();
        return view("admin.order.form", compact("statusId"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function venderHandling()
    {
        $orders = Order::with(['deliveryMethod', 'payment', 'product'])->orderBy("date_created", "desc")->whereNotNull("vender_id")->get();
        return view("admin.order.vender.venderList", compact("orders"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function orderHistory()
    {
        try {
            $orderDetail = OrderDetails::orderBy('id', 'desc')
                ->paginate(5);
            dd($orderDetail->product->cartitem);
            $orderSuccess = OrderDetails::orderBy('id', 'desc');
        } catch (\Throwable $error) {
        }
        return view('client.account.orderhistory', compact('orderDetail'));
    }

        public function apply(Request $request)
        {
            $orders = Order::all();
            $id = $request->id - 1;
            $order = $orders[$id];
            if ($order->status_code >= 4) {
                return;
            }
            $order->status_code = sprintf('%02d', $order->status_code  + 1);
            $order->date_modified = now(UnixConverter::VN_TIMEZONE);
            $order->save();
            return back()->with('response_message', Message::out('success', 'Duyệt đơn thành công.'));
        }
    public function cancel(Request $request)
    {
        $orders = Order::all();
        $id = $request->id - 1;
        $order = $orders[$id];
        $order->status_code = '05`';
        $order->save();
        return back()->with('response_message', Message::out('success', 'Duyệt đơn thành công.'));
    }
    public function taked(Request $request)
    {
        $orders = Order::all();
        $id = $request->id - 1;
        $order = $orders[$id];
        $order->vender_id = $this->admin->id;
        $order->save();
        return back()->with('response_message', Message::out('success', 'Nhận đơn thành công.'));
    }
    public function checkout(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Find the active cart for the user
        $cart = Cart::where('user_id', $user->id)
            ->where('active', 1)
            ->first();
        // If no active cart found, redirect back with an error message
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Retrieve cart items for the cart
        $cartItems = CartItem::where('cart_id', $cart->id)
            ->get();

        // Calculate total price
        $totalPrice = $request->input('totalAmount');

        // Iterate through cart items to attach addons
        foreach ($cartItems as $cartItem) {
            // Retrieve addons for the current cart item
            $addons = CartItemAddOn::where('cart_item_id', $cartItem->id)
                ->get();

            // Attach addons to the cart item
            $cartItem->addons = $addons;
        }

        // Update total price of the cart
        $cart->total_price = $totalPrice;
        $cart->save();

        $discountAmount = session('discountAmount', 0);
        $tax = session('newTax', $cart->estimated_tax ?? 0);
        $newTotal = session('newTotal', $totalPrice + $tax - $discountAmount);

        // Update session with initialized values
        session([
            'discountAmount' => $discountAmount,
            'newTax' => $tax,
            'newTotal' => $newTotal
        ]);
        // Return the view with cart and cart items data
        return view('client.checkout-orders.checkout', compact('cart', 'cartItems', 'discountAmount', 'tax', 'newTotal'));
    }
    public function applyPromotion(Request $request)
    {
        $promotionCode = $request->input('promotion_code');

        // Validate promotion code input
        if (!$promotionCode) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập mã khuyến mãi.']);
        }
        $user = Auth::user();

        // Find the active cart for the user
        $cart = Cart::where('user_id', $user->id)
            ->where('active', 1)
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không thể tìm thấy giỏ hàng của bạn']);
        }

        // Retrieve promotion
        $promotion = Promotion::where('code', $promotionCode)
            ->where('expiration_date', '>', now())
            ->first();
        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.']);
        }

        // Calculate total price including add-ons
        $cartItems = $cart->cartItems()->get();
        if (!$cartItems) {
            return response()->json(['success' => false, 'message' => 'Không thể tìm thấy sản phẩm trong giỏ hàng.']);
        }

        $totalPrice = $cart->total_price;

        // Check if cart total meets minimum eligible amount for promotion
        if ($totalPrice < $promotion->minimum_eligible_amount) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn chưa đủ số tiền tối thiểu để áp dụng mã khuyến mãi này.']);
        }
        $discountAmount = 0;
        //Calculate discount amount based on promotion
        if ($promotion->use_percentage) {
            $discountAmount = min($totalPrice * ($promotion->use_percentage / 100), $promotion->cap_amount);
        } else {
            $discountAmount = min($promotion->use_ammount, $promotion->cap_amount);
        }

        // Apply discount to total price

        // Retrieve tax from cart and calculate new total
        $tax = $cart->estimated_tax ?? 0; // Assuming estimated_tax is the tax attribute in the Cart model
        $newTotal = $totalPrice - $discountAmount + $tax;

        // Update session with new totals (if needed)
        session([
            'discountAmount' => $discountAmount,
            'newTax' => $tax,
            'newTotal' => $newTotal
        ]);

        return response()->json([
            'success' => true,
            'discountAmount' => number_format($discountAmount, 0, ',', '.'),
            'newTax' => number_format($tax, 0, ',', '.'),
            'newTotal' => number_format($newTotal, 0, ',', '.')
        ]);
    }

    public function shipping(Request $request)
    {
        $address = Session::get('address');

        $discountAmount = session('discountAmount', 0);
        $newTax = session('newTax', 0);
        $newTotal = session('newTotal', 0);
        return view('client.checkout-orders.shipping', compact('address', 'discountAmount', 'newTax', 'newTotal'));
    }

    public function editShipAddress(Request $request)
    {
        // Nếu là phương thức PUT, xử lý việc cập nhật địa chỉ
        // if ($request->isMethod('PUT')) {
        //     if (!$request->filled(['row3', 'inputAddress', 'district', 'city', 'country', 'inputPostal'])) {
        //         return redirect()->back()->withInput()->withErrors(['errors' => 'Vui lòng điền đầy đủ thông tin.']);
        //     }
        //     // Validate form data
        //     $request->validate([
        //         'row3' => 'required',
        //         'inputAddress' => 'required',
        //         'district' => 'required',
        //         'city' => 'required',
        //         'country' => 'required',
        //         'inputPostal' => 'required',
        //     ], [
        //         'row3.required' => 'Vui lòng chọn loại địa chỉ.',
        //         'inputAddress.required' => 'Vui lòng nhập địa chỉ.',
        //         'district.required' => 'Vui lòng nhập quận/huyện.',
        //         'city.required' => 'Vui lòng nhập thành phố/tỉnh.',
        //         'country.required' => 'Vui lòng nhập quốc gia.',
        //         'inputPostal.required' => 'Vui lòng nhập mã bưu điện.',
        //     ]);

        //     // Lấy thông tin người dùng
        //     $user = User::find(auth()->id());

        //     $addressParts = [
        //         $request->input('inputPostal'),
        //         $request->input('inputAddress'),
        //         $request->input('district'),
        //         $request->input('city'),
        //         $request->input('country')
        //     ];

        //     // Kiểm tra loại địa chỉ là Residential thì gán CompanyName về chuỗi trống
        //     if ($request->input('row3') !== 'Residential') {
        //         // Kiểm tra nếu người dùng có nhập tên công ty
        //         if ($request->input('inputCompanyName')) {
        //             // Thêm inputCompany vào đầu mảng
        //             array_unshift($addressParts, $request->input('inputCompanyName'));
        //         }
        //     }
        //     // Ghép các phần tử của mảng thành địa chỉ
        //     $address = implode('|,|', $addressParts);

        //     $user = User::find(auth()->id());
        //     $user->address = $address;
        //     dd($user->address);
        //     $user->save();

        //     return redirect()->back()->with('success', 'Đã cập nhật địa chỉ mới.');
        // }
        $address = Session::get('address');
        dd($address);
    }
}
