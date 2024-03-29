@extends('dashboard')
@section('content')
  <div class="card " style="margin-top: 35px">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
          <path fill="#4db051"
            d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
        </svg> <strong>Errors </strong> {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (isset($success))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
          <path fill="#4db051"
            d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
        </svg> <strong>OK! </strong> {{ $success }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="card-header">
      <h5 class="card-title">Danh sách khách hàng</h5>
    </div>
    <div class="card-body pt-0">
      <div class="col">
        <form id="form-search-customer" class="" action="">
          <div class="row py-3">
            <div class="col-3">
              <label for="s-name" class="form-label"><strong>Tên</strong></label>
              <input type="text" name="s-name" id="s-name" class="form-control" placeholder="Nhập họ tên" />
            </div>
            <div class="col-3">
              <label for="s-email" class="form-label"><strong>Email</strong></label>
              <input type="text" name="s-email" id="s-email" class="form-control" placeholder="Nhập Email" />
            </div>
            <div class="col-3">
              <label for="s-is_active" class="form-label"><strong>Trạng thái</strong></label>
              <select type="text" class="form-select" id="s-is_active" name="s-is_active">
                <option selected value='' disabled>Chọn trạng thái</option>
                <option value="1">Đang hoạt động</option>
                <option value="0">Tạm khóa</option>
              </select>
            </div>
            <div class="col-3">
              <label for="s-address" class="form-label"><strong>Địa chỉ</strong></label>
              <input type="text" class="form-control" id="s-address" name="s-address" placeholder="Nhập địa chỉ" />
            </div>
            <button type="submit" class="hidden"></button>
          </div>
        </form>
        <div class="row pb-3">
          <div class="col-6 d-flex justify-content-between  ">
            <div class="" style="border: 1px solid #0b5ed7; border-radius: 8px;">
              <label class="ps-2" for=""><svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 640 512"><path fill="#0b5ed7" d="M96 128a128 128 0 1 1 256 0a128 128 0 1 1-256 0M0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3M504 312v-64h-64c-13.3 0-24-10.7-24-24s10.7-24 24-24h64v-64c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h-64v64c0 13.3-10.7 24-24 24s-24-10.7-24-24"/></svg></label>
              <a href="#" class="create btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormCustomer"> Thêm mới </a>
            </div>
            <div class="" style=" border: 1px solid #157347; border-radius: 8px;">
              <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                <path fill="#1ea262"
                  d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24m296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24m-124 88c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20m64 0c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20" />
              </svg>
              <a id="export_customer" class="export btn btn-success" href=""> Export CSV</a>
            </div>
            <form id="importCustomer" action="/customers/import" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input class="hidden" type="file" id="formFile" name="customer-file" accept=".xlsx, .xls, .csv, .ods">
              {{-- <div class="row"> --}}
              <div class="d-flex justify-content-between align-items-center" style=" border: 1px solid #157347; border-radius: 8px;">
                <label class="px-2" for="formFile" class="form-label"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                    <path fill="#1ea262"
                      d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24m216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24m-124 88c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20m64 0c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20" />
                  </svg></label>
                <button class="import btn btn-success"> Import CSV</button>
              </div>
              {{-- </div> --}}
            </form>

            {{-- </div> --}}

          </div>
          <div class="col-2"></div>
          <div class="col-4 d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center" style="border: 1px solid #0b5ed7; border-radius: 8px;">
              <label for="c_search" class="px-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#0b5ed7" d="M10.5 2a8.5 8.5 0 1 0 5.262 15.176l3.652 3.652a1 1 0 0 0 1.414-1.414l-3.652-3.652A8.5 8.5 0 0 0 10.5 2M4 10.5a6.5 6.5 0 1 1 13 0a6.5 6.5 0 0 1-13 0"/></g></svg>
              </label>
              <button id="c_search" type="submit" class="btn btn-primary c_search">Tìm kiếm</button>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="border: 1px solid #157347; border-radius: 8px;">
              <label for="clear-search" class="pe-2"><svg class=" ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#157347" d="m12 14.122l5.303 5.303a1.5 1.5 0 0 0 2.122-2.122L14.12 12l5.304-5.303a1.5 1.5 0 1 0-2.122-2.121L12 9.879L6.697 4.576a1.5 1.5 0 1 0-2.122 2.12L9.88 12l-5.304 5.304a1.5 1.5 0 1 0 2.122 2.12z"/></g></svg></label>
              <button id="clear-search" class="btn btn-success clear-search">Xóa tìm kiếm</button>
            </div>
          </div>
        </div>

      </div>
      @include('customers.table')
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="FormCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm khách hàng</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-customer" action="" method="post">
          @csrf
          <div class="modal-body">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="c_name">Tên</label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input type="hidden" id="c_id" name="customer_id" value="" />
                  <input type="text" class="form-control" id="c_name" name="customer_name" placeholder="Nhập họ tên" aria-describedby="basic-icon-default-fullname2" />
                </div>
                <div class="message-error c_name text-danger mt-1"></div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for=c_email">Email</label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input type="text" class="form-control " id="c_email" name="email" placeholder="Nhập Email" aria-describedby="basic-icon-default-fullname2" />
                </div>
                <div class="message-error c_email text-danger mt-1"></div>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="c_tel_num">Số điện thoại</label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input class="form-control group_role" id="c_tel_num" name="tel_num" placeholder="Điện thoại">

                  </input>
                </div>
                <div class="message-error c_tel_num text-danger mt-1"></div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="c_address">Địa chỉ</label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <input type="text" class="form-control " id="c_address" name="address" placeholder="Địa chỉ" aria-describedby="basic-icon-default-fullname2" />
                </div>
                <div class="message-error c_address text-danger mt-1"></div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Trạng
                thái</label>
              <div class="col-sm-9">
                <div class="input-group input-group-merge">
                  <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input u-is-active" id="c_is_active" name="is-active" value=1>
                    <label class="form-check-label text-primary " for="flexCheckDefault">Đang hoạt
                      động</label>
                  </div>
                </div>
                <div class="message-error c_is_active text-danger"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="c_close" class="btn btn-secondary " data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="c_save" class="btn btn-primary">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{ asset('asset/handle_customer.js') }}"></script>
@endsection
