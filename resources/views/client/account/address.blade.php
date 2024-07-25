@extends('client.layout')

@section('title', 'address')
@section('content')
    <main class="bg-black py-3">
        <div class="container bg-white" style="height:80vh;">
            <div class="row">
            <div class="col-sm-3">
                     <!-- Menu desktop -->
                     <ul class="list-group list-group-flush desktop-menu d-none d-lg-block">
                        <li class="list-group-item d-flex flex-column">
                            <strong class="fs-5">Tài khoản của tôi</strong>
                            <strong class="form-text">Xin chào, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }}</strong>
                            <strong class="form-text">Mã tài khoản: {{ auth()->user()->id }}</strong>
                        </li>
                        <li class="list-group-item"><a href="/orderhistory" class="form-text text-decoration-none text-dark"><i class="bi bi-handbag fs-2"></i> Lịch sử mua hàng</a></li>
                        <li class="list-group-item"><a href="/address" class="form-text text-decoration-none text-dark"><i class="bi bi-list-ul fs-2"></i> Địa chỉ</a></li>
                        <li class="list-group-item"><a href="/profile" class="form-text text-decoration-none text-dark"><i class="bi bi-person-check fs-2"></i> Thông tin tài khoản</a></li>
                        <li class="list-group-item"><a href="/checkoutpreferences" class="form-text text-decoration-none text-dark"><i class="bi bi-receipt-cutoff fs-2"></i> Tùy chọn thanh toán</a></li>
                    </ul>

                    <div class="dropdown d-lg-none">
                        <div class="d-flex flex-column">
                            <strong class="fs-5">Tài khoản của tôi</strong>
                            <strong class="form-text">Xin chào, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }}</strong>
                            <strong class="form-text">Mã tài khoản: {{ auth()->user()->id }}</strong>
                        </div>
                        <div class="row justify-content-center position-relative">
                            <button class="col-8 btn btn-outline-dark dropdown-toggle d-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Menu
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="list-group-item"><a href="/orderhistory" class="dropdown-item form-text text-decoration-none text-dark">Lịch sử mua hàng</a></li>
                                <li class="list-group-item"><a href="/address" class="dropdown-item form-text text-decoration-none text-dark">Địa chỉ</a></li>
                                <li class="list-group-item"><a href="/profile" class="dropdown-item form-text text-decoration-none text-dark">Thông tin tài khoản</a></li>
                                <li class="list-group-item"><a href="/checkoutpreferences" class="dropdown-item form-text text-decoration-none text-dark">Tùy chọn thanh toán</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="bg-body-secondary p-3 row fw-bold">
                        Địa chỉ của bạn
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>
                                <p class="form-text text-dark">Địa chỉ</p>
                                @if (auth()->user()->address)
                                    <p class="form-text text-dark">Mr/Ms {{ auth()->user()->last_name }}
                                        {{ auth()->user()->first_name }}</p>
                                    <p class="form-text text-dark">{{ auth()->user()->country_code }}</p>
                                    <p class="form-text text-dark">{{ str_replace('|,|', ', ', auth()->user()->address) }}
                                    </p>
                            </strong>
                        </div>
                        <div class="col-sm-6">
                            <p class="form-text text-dark">
                                @if (auth()->user()->phone_number)
                                    Số điện thoại: {{ auth()->user()->phone_number }}
                                @else
                                    <p class="form-text text-dark">Số điện thoại: Chưa có số điện thoại.</p>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('edit-address') }}" class="btn btn-outline-dark col-sm-3">CHỈNH SỬA ĐỊA CHỈ</a>
                        <span class="form-text"><i class="bi bi-check"></i><small> Địa chỉ giao hàng mặc định của
                                tôi</small></span>
                        <span class="form-text"><i class="bi bi-check"></i><small> Địa chỉ thanh toán mặc định của
                                tôi</small></span>
                    @else
                        <div class="fs-5 form-text">
                            <p class="text-dark-emphasis">Hãy thêm địa chỉ của bạn.</p>
                        </div>
                        @endif
                    </div>
                    @if (!auth()->user()->address)
                        <div class="row bg-secondary-subtle p-3 justify-content-end">
                            <a href="/addaddress" class="btn btn-outline-dark col-sm-3">THÊM ĐỊA CHỈ</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
