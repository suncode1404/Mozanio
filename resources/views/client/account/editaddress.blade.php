@extends('client.layout')

@section('title', 'editaddress')
@section('content')
<main class="bg-black py-3">
    <div class="container bg-white">
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
                <form action="{{ route('edit-address') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-body-secondary p-3 row fw-bold">
                        Chỉnh sửa địa chỉ
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <p class="form-text text-dark">Hãy hoàn thành mẫu đơn dưới dây. Các trường có dấu * là bắt buộc.</p>
                        <p class="form-text text-dark">Các trường bắt buộc được đánh dấu *</p>
                        <hr>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <div class="mb-6 row">
                            <div class="col-sm-5">
                                <p class="form-text">Địa chỉ của tôi <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="radio" value="Residential" class="form-check-input residentialRadio1" name="row3" id="residentialRadio">
                                <label class="form-check-label form-text" for="residentialRadio">
                                    Khu dân cư
                                </label>
                            </div>
                            <div class="col-sm-3 form-check">
                                <input type="radio" value="Company" class="form-check-input companyRadio1" name="row3" id="companyRadio">
                                <label class="form-check-label form-text" for="companyRadio">
                                    Công ty
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-1 d-none companyCheckGroups1">
                            <div class="mb-6 row">
                                <label for="inputCompanyName" class="col-sm-4 col-form-label form-text">Tên công ty <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputCompanyName" name="inputCompanyName" value="{{ old('inputCompanyName') ?: $address['inputCompanyName'] }}" placeholder="{{ $address['inputCompanyName'] }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-6 row">
                            <label for="inputCountry" class="col-sm-4 col-form-label form-text">Quốc gia <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ $address['country'] }}" placeholder="{{ $address['country'] }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-6 row">
                            <label for="inputTypeCountry" class="col-sm-4 col-form-label form-text">Huyện, Tỉnh - Thành phố <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" id="inputDistrict" value="{{ old('district') ?: $address['district'] }}" placeholder="{{ $address['district'] }}">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="inputCity" value="{{ old('city') ?: $address['city'] }}" placeholder="{{ $address['city'] }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-6 row">
                            <label for="inputAddress" class="col-sm-4 col-form-label form-text">Địa chỉ <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputAddress" name="inputAddress" value="{{ old('inputAddress') ?: $address['inputAddress'] }}" placeholder="{{ $address['inputAddress'] }}">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-6 row">
                            <label for="inputPostal" class="col-sm-4 col-form-label form-text">Mã bưu điện <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputPostal" name="inputPostal" placeholder="{{ $address['inputPostal'] }}" value="{{ old('inputPostal') ?: $address['inputPostal'] }}">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex gap-2 justify-content-end row p-3">
                            <a href="/address" class="btn btn-outline-dark col-sm-3">Hủy bỏ</a>
                            <button class="btn btn-outline-dark col-sm-3" type="submit">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const inputCompanyName = "{{ $address['inputCompanyName'] }}"; // Lấy thông tin công ty từ blade template
    const companyRadio = document.getElementById("companyRadio");
    const companyCheckGroups = document.querySelectorAll('.companyCheckGroups1');

    // Nếu có thông tin về công ty, hiển thị các nhóm công ty
    if (inputCompanyName) {
        companyRadio.checked = true;
        companyCheckGroups.forEach(function(group) {
            group.classList.remove("d-none");
        });
    }
});
</script>

@endsection