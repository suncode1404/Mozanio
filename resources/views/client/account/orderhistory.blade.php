@extends('client.layout')

@section('title', 'orderhistory')
@section('content')
    <main class="bg-black py-3">
        <div class="container bg-white">
            <div class="row">
                <div class="col-sm-3">
                    <!-- Menu desktop -->
                    <ul class="list-group list-group-flush desktop-menu d-none d-lg-block">
                        <li class="list-group-item d-flex flex-column">
                            <strong class="fs-5">Tài khoản của tôi</strong>
                            <strong class="form-text">Xin chào, {{ auth()->user()->last_name }}
                                {{ auth()->user()->first_name }}</strong>
                            <strong class="form-text">Mã tài khoản: {{ auth()->user()->id }}</strong>
                        </li>
                        <li class="list-group-item"><a href="/orderhistory"
                                class="form-text text-decoration-none text-dark"><i class="bi bi-handbag fs-2"></i> Lịch sử
                                mua hàng</a></li>
                        <li class="list-group-item"><a href="/address" class="form-text text-decoration-none text-dark"><i
                                    class="bi bi-list-ul fs-2"></i> Địa chỉ</a></li>
                        <li class="list-group-item"><a href="/profile" class="form-text text-decoration-none text-dark"><i
                                    class="bi bi-person-check fs-2"></i> Thông tin tài khoản</a></li>
                        <li class="list-group-item"><a href="/checkoutpreferences"
                                class="form-text text-decoration-none text-dark"><i class="bi bi-receipt-cutoff fs-2"></i>
                                Tùy chọn thanh toán</a></li>
                    </ul>

                    <div class="dropdown d-lg-none">
                        <div class="d-flex flex-column">
                            <strong class="fs-5">Tài khoản của tôi</strong>
                            <strong class="form-text">Xin chào, {{ auth()->user()->last_name }}
                                {{ auth()->user()->first_name }}</strong>
                            <strong class="form-text">Mã tài khoản: {{ auth()->user()->id }}</strong>
                        </div>
                        <div class="row justify-content-center position-relative">
                            <button class="col-8 btn btn-outline-dark dropdown-toggle d-block" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Menu
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="list-group-item"><a href="/orderhistory"
                                        class="dropdown-item form-text text-decoration-none text-dark">Lịch sử mua hàng</a>
                                </li>
                                <li class="list-group-item"><a href="/address"
                                        class="dropdown-item form-text text-decoration-none text-dark">Địa chỉ</a></li>
                                <li class="list-group-item"><a href="/profile"
                                        class="dropdown-item form-text text-decoration-none text-dark">Thông tin tài
                                        khoản</a></li>
                                <li class="list-group-item"><a href="/checkoutpreferences"
                                        class="dropdown-item form-text text-decoration-none text-dark">Tùy chọn thanh
                                        toán</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 bg-body-tertiary">
                    <div class="row">
                        <nav>
                            <div class="nav nav-tabs align-items-center" id="nav-tab" role="tablist">
                                <button class="nav-link text-dark active" id="nav-all-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all"
                                    aria-selected="true">Tất cả</button>
                                <button class="nav-link text-dark" id="nav-wait-order-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-wait-order" type="button" role="tab"
                                    aria-controls="nav-wait-order" aria-selected="false">Đã đặt</button>
                                <button class="nav-link text-dark" id="nav-wait-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-wait" type="button" role="tab" aria-controls="nav-wait"
                                    aria-selected="false">Đang vận chuyển</button>
                                <button class="nav-link text-dark" id="nav-complete-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-complete" type="button" role="tab"
                                    aria-controls="nav-complete" aria-selected="false">Giao hàng thành công</button>
                                <button class="nav-link text-dark" id="nav-cancel-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-cancel" type="button" role="tab" aria-controls="nav-cancel"
                                    aria-selected="false">Đã hủy</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab" tabindex="0">
                                <div class="table-responsive">
                                    {{-- {{dd($orderDetail)}} --}}
                                    @if (!empty($orderDetail))
                                        @foreach ($orderDetail as $orderdetail)
                                            <table class="table my-2">
                                                <thead>
                                                    <tr>
                                                        <th class="status-order_title"
                                                            style="width:190px;max-width:190px;">
                                                            Tình
                                                            trạng đơn hàng</th>
                                                        <th colspan="3">
                                                            <div class="d-flex justify-content-end">
                                                                <i class="bi bi-car-front"></i>
                                                                @if (!empty($orderdetail->order->status))
                                                                    @include('client.account.fliedStatus', [
                                                                        'status_id' => $orderdetail->order->status,
                                                                    ])
                                                                @else
                                                                    <small class="text-body-tertiary ms-2">Chờ xử
                                                                        lý</small>
                                                                @endif
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-white border-bottom" style="position: relative">
                                                        <td style="" colspan="1"
                                                            class="border-0 d-flex justify-content-center">
                                                            <div class="box-img-history">
                                                                <img src="{{ asset('img/product/' . $orderdetail->product->internal_image_path) }}"
                                                                    alt="" width="100">
                                                            </div>
                                                        </td>
                                                        <td colspan="2" class="align-middle border-0">
                                                            <div class="form-text">
                                                                <strong>{{ $orderdetail->product->name }}</strong>
                                                                <p class="my-0"><small class="form-text">Phân loại hàng:
                                                                        {{ $orderdetail->product->category->name }}</small>
                                                                </p>
                                                                {{-- {{ dd($orderdetail->product->cartitem[0]->product_id) }} --}}

                                                                <p class="my-0"><small class="form-text">Size:
                                                                        @if (!empty($orderdetail->product->cartitem) && !empty($orderdetail->product->cartitem[0]->product_id))
                                                                            {{ $orderdetail->product->cartitem[0]->size }}
                                                                        @endif
                                                                    </small>
                                                                </p>
                                                                <div class="form-text">
                                                                    <p class="m-0">Số lượng:<span
                                                                            class="ms-2">{{ $orderdetail->order->amount}}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-danger align-middle text-end border-0">
                                                            <br>
                                                            <p class="text-dark">Tổng tiền: <span
                                                                    class="fs-5 text-success">
                                                                    {{ number_format($orderdetail->order->payable_amount, 0, ',', '.') }}</span>
                                                                <span class="text-success">VND</span>
                                                            </p>
                                                        </td>
                                                        <td class="position-absolute p-0 toggle-details "
                                                            style="bottom: 0; right: 0; cursor: pointer;margin-right:10px;">
                                                            <div class="d-none d-lg-block">
                                                                <span class="toggle-icon"
                                                                    style="font-size: 13px;color:var(--text-color)">Chi
                                                                    tiết</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="details-row">
                                                        <td class="" style="font-size: 13px;" scope="col">
                                                            <div class="my-2">
                                                                <span>Mã đơn hàng</span>
                                                                <span>: {{ $orderdetail->order->id }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Mã số thuế</span>
                                                                <span>: {{ $orderdetail->product->cartitem->cart->estimated_tax}}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Mô tả</span>
                                                                <span>:
                                                                    {{ $orderdetail->order->customer_special_notes }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="" style="font-size: 13px;">
                                                            <div class="my-2">
                                                                <span>Người đặt</span>
                                                                <span>: {{ $orderdetail->order->user_name }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Email</span>
                                                                <span>: {{ $orderdetail->order->email }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Số điện thoại</span>
                                                                <span>: {{ $orderdetail->order->phone }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="" style="font-size: 13px;">
                                                            <div class="my-2">
                                                                <span>Địa chỉ</span>
                                                                <span>: {{ $orderdetail->order->ship_address }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Vận chuyển</span>
                                                                <span>:
                                                                    {{ $orderdetail->order->deliveryMethod->short_description }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Nguyên liệu</span>
                                                                <span>: 200g đường, 200g muối, 300g bột ngọt</span>
                                                            </div>
                                                        </td>
                                                        <td class="" style="font-size: 13px;">
                                                            <div class="my-2">
                                                                <span>Ngày đặt đơn</span>
                                                                <span>:
                                                                    {{ date('Y-m-d', strtotime($orderdetail->order->date_created)) }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Cập nhật đơn lần cuối</span>
                                                                <span>:
                                                                    {{ date('Y-m-d', strtotime($orderdetail->order->date_modified)) }}</span>
                                                            </div>
                                                            <div class="my-2">
                                                                <span>Phương thức thanh toán</span>
                                                                <span>:
                                                                    {{ $orderdetail->order->payment->short_description }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                        @if ($orderDetail->hasPages())
                                            <nav aria-label="Page navigation example" style="width:100%">
                                                <ul class="pagination d-flex justify-content-center">
                                                    <!-- Liên kết đến trang trước đó -->
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $orderDetail->previousPageUrl() }}"
                                                            aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>

                                                    <!-- Hiển thị các trang -->
                                                    @for ($i = 1; $i <= $orderDetail->lastPage(); $i++)
                                                        <li
                                                            class="page-item {{ $orderDetail->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $orderDetail->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    <!-- Liên kết đến trang kế tiếp -->
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $orderDetail->nextPageUrl() }}"
                                                            aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-wait-order" role="tabpanel"
                                aria-labelledby="nav-wait-order-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Loại sản phẩm</th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <i class="bi bi-car-front d-none d-lg-block"></i><small
                                                            class="text-success d-none d-lg-block"> Đơn hàng đã được đặt
                                                            |</small><strong class="text-danger"> Chờ đơn vị vận
                                                            chuyển</strong>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <img src="{{ asset('img/product-1.avif') }}" alt=""
                                                        width="100">
                                                </th>
                                                <td colspan="2" class="align-middle">
                                                    <div class="form-text">
                                                        <strong>Tên sản phẩm</strong>
                                                        <p><small class="form-text">Phân loại hàng: Màu - Size</small></p>
                                                        Số lượng: x1
                                                    </div>
                                                </td>
                                                <td class="text-danger text-end">250.000đ
                                                    <p class="text-dark">Thành tiền: <span
                                                            class="fs-4 text-danger">206.000đ</span></p>
                                                    <button class="btn btn-outline-dark">Hủy đơn</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-wait" role="tabpanel" aria-labelledby="nav-wait-tab"
                                tabindex="0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Loại sản phẩm</th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <i class="bi bi-car-front d-none d-lg-block"></i><small
                                                            class="text-success d-none d-lg-block"> Đơn hàng đã đang được
                                                            giao |</small><strong class="text-danger"> Đang giao</strong>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <img src="{{ asset('img/product-1.avif') }}" alt=""
                                                        width="100">
                                                </th>
                                                <td colspan="2" class="align-middle">
                                                    <div class="form-text">
                                                        <strong>Tên sản phẩm</strong>
                                                        <p><small class="form-text">Phân loại hàng: Màu - Size</small></p>
                                                        Số lượng: x1
                                                    </div>
                                                </td>
                                                <td class="text-danger text-end">250.000đ
                                                    <p class="text-dark">Thành tiền: <span
                                                            class="fs-4 text-danger">206.000đ</span></p>
                                                    <button class="btn btn-outline-dark">Liên hệ Shop</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-complete" role="tabpanel"
                                aria-labelledby="nav-complete-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Loại sản phẩm</th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <i class="bi bi-car-front d-none d-lg-block"></i><small
                                                            class="text-success d-none d-lg-block"> Đơn hàng đã được giao
                                                            thành công |</small><strong class="text-danger"> Hoàn
                                                            thành</strong>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <img src="{{ asset('img/product-1.avif') }}" alt=""
                                                        width="100">
                                                </th>
                                                <td colspan="2" class="align-middle">
                                                    <div class="form-text">
                                                        <strong>Tên sản phẩm</strong>
                                                        <p><small class="form-text">Phân loại hàng: Màu - Size</small></p>
                                                        Số lượng: x1
                                                    </div>
                                                </td>
                                                <td class="text-danger text-end">250.000đ
                                                    <p class="text-dark">Thành tiền: <span
                                                            class="fs-4 text-danger">206.000đ</span></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab"
                                tabindex="0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Loại sản phẩm</th>
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <i class="bi bi-car-front d-none d-lg-block"></i><small
                                                            class="text-success d-none d-lg-block"> Đơn hàng đã hủy
                                                            |</small><strong class="text-danger"> Đã hủy</strong>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <img src="{{ asset('img/product-1.avif') }}" alt=""
                                                        width="100">
                                                </th>
                                                <td colspan="2" class="align-middle">
                                                    <div class="form-text">
                                                        <strong>Tên sản phẩm</strong>
                                                        <p><small class="form-text">Phân loại hàng: Màu - Size</small></p>
                                                        Số lượng: x1
                                                    </div>
                                                </td>
                                                <td class="text-danger text-end">250.000đ
                                                    <p class="text-dark">Thành tiền: <span
                                                            class="fs-4 text-danger">206.000đ</span></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-details').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    console.log('Icon clicked');
                    const detailsRow = toggle.closest('tr').nextElementSibling;
                    const icon = toggle.querySelector('.toggle-icon');

                    if (detailsRow.classList.contains('showOrder')) {
                        console.log('Hiding details');
                        detailsRow.classList.remove('showOrder');
                        icon.classList.remove('rotate-180');
                        setTimeout(() => {
                            detailsRow.style.display = 'none';
                        }, 500);
                    } else {
                        console.log('Showing details');
                        detailsRow.style.display = 'table-row';
                        setTimeout(() => {
                            detailsRow.classList.add('showOrder');
                            icon.classList.add('rotate-180');
                        }, 10);
                    }
                });
            });
        });
    </script>
@endsection
