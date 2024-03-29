@extends('dashboard')
@section('content')

<style>
  .note-editor.note-frame.panel.panel-default{
    width: 100%!important;
  }
</style>

<div class="card" style="margin-top: 35px">
  <div id="notification_alert">
    
  </div>
    
    <div class="card-header">      
      <h5 class="card-title">Danh sách sản phẩm</h5>
    </div>
    <div class="card-body pt-0">
      <form id="form-search-user">
        <div class="row py-3 ">
          <div class="col-3">
            <label for="s-name" class="form-label"><strong>Tên sản phẩm</strong></label>
            <input type="text" name="s_name" id="s_name" class="form-control" placeholder="Nhập tên sản phẩm" />
          </div>
          <div class="col-3">
            <label for="s_is_sales" class="form-label"><strong>Trạng thái</strong></label>
            <select type="text" class="form-select" id="s_is_sales" name="s_is_sales">
              <option selected value="" disabled>Chọn trạng thái</option>
              <option value=1>Đang bán</option>
              <option value=0>Ngừng bán</option>
              <option value=2>Hết hàng</option>
            </select>
          </div>
          <div class="col-3">
            <label for="s_from" class="form-label">Giá bán từ</label>
            <input type="number" name="s_from" id="s_from" class="form-control" placeholder="" />
          </div>
          <div class="col-1  d-flex justify-content-between align-items-center">
            <strong class="ps-4 ">~~~</strong>
          </div>
          <div class="col-2">
            <label for="s_to" class="form-label">Giá bán đến</label>
            <input type="number" class="form-control" id="s_to" name="s_to" placeholder="" />
          </div>
        </div>
        <div class="col pb-3 d-flex justify-content-between">
          <div class="col-4 d-flex">
            <div class="" style="border: 1px solid #0b5ed7; border-radius: 8px;">
              <label class="ps-2" for="create-product"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 640 512"><path fill="#0b5ed7" d="M96 128a128 128 0 1 1 256 0a128 128 0 1 1-256 0M0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3M504 312v-64h-64c-13.3 0-24-10.7-24-24s10.7-24 24-24h64v-64c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h-64v64c0 13.3-10.7 24-24 24s-24-10.7-24-24"/></svg></label>
              <a href="#" id="create-product" class="create btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormProduct"> Thêm mới </a href="#">
            </div>
          </div>
          <div class="col-3"></div>
          <div class="col-4 d-flex justify-content-between"">
            <div class=" d-flex  align-items-center " style="border: 1px solid #0b5ed7; border-radius: 8px;">
              <label for="p_search" class="px-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#0b5ed7" d="M10.5 2a8.5 8.5 0 1 0 5.262 15.176l3.652 3.652a1 1 0 0 0 1.414-1.414l-3.652-3.652A8.5 8.5 0 0 0 10.5 2M4 10.5a6.5 6.5 0 1 1 13 0a6.5 6.5 0 0 1-13 0"/></g></svg>
              </label>
              <button id="p_search" class="btn btn-primary p_search">Tìm kiếm</button>
            </div>
            <div class="   d-flex  align-items-center " style="border: 1px solid #157347; border-radius: 8px;">
              <label for="clear-search" class="pe-2"><svg class=" ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#157347" d="m12 14.122l5.303 5.303a1.5 1.5 0 0 0 2.122-2.122L14.12 12l5.304-5.303a1.5 1.5 0 1 0-2.122-2.121L12 9.879L6.697 4.576a1.5 1.5 0 1 0-2.122 2.12L9.88 12l-5.304 5.304a1.5 1.5 0 1 0 2.122 2.12z"/></g></svg></label>
              <button class="btn btn-success p_clear_search">Xóa tìm</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    @include('products.table')
  </div>
  <!-- Modal -->
  <div class="modal fade" id="FormProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm sản phẩm</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="notification_alert_modal">
        </div>
        <form id="form-product" action="" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body row">
            <div class="col-7">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Tên sản phẩm</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="hidden" id="p_id" name="product_id" value="" />
                    <input type="text" class="form-control" id="p_name" name="product_name" placeholder="Nhập tên sản phẩm" aria-describedby="basic-icon-default-fullname2" value=""/>
                  </div>
                  <div class="message-error p_name text-danger mt-1"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Giá</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="number" class="form-control " id="p_price" name="product_price" placeholder="Nhập giá bán" aria-describedby="basic-icon-default-fullname2" min="0" />
                  </div>
                  <div class="message-error p_price text-danger mt-1"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Mô tả</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">

                  {{-- <div id="description" name="description"></div> --}}

                    <textarea 
                      {{-- type="text" --}}
                      {{-- class="form-control"  --}}
                      id="description" 
                      name="description" 
                      placeholder="Nhập mô tả sản phẩm ..." 
                      {{-- aria-describedby="basic-icon-default-fullname2"  --}}
                      value="">
                    </textarea>
                    {{-- <script> CKEDITOR.replace( 'description' ) </script> --}}

                  </div>
                  <div class="message-error p_description text-danger mt-1"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Trạng thái</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <select type="text" class="form-select" id="p_is_sales" name="is_sales">
                      <option selected value="" disabled>Chọn trạng thái</option>
                      <option value=1>Có hàng bán</option>
                      <option value=0>Dừng bán</option>
                      <option value=2>Hết hàng</option>
                    </select>
                  </div>
                  <div class="message-error p_is_sales text-danger mt-1"></div>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="col">
                <label for="product_image" class="form-label">Hình ảnh</label>
                <div id="show_img">
                </div>
                <div class="input-group mb-3">
                  <button id="delete-img" class="btn btn-danger ">Xóa hình</button>
                  <label class="input-group-text" for="product_name">Upload</label>
                  <input type="file" class="form-control" id="product_image" name="product_image">
                </div>              
                <div class="message-error p_product_image text-danger mt-1"></div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" id="p_close" class="btn btn-secondary " data-bs-dismiss="modal">Hủy</button>
            <button type="button" id="c_save" class="btn btn-primary p_save_product">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{ asset('asset/handle_product.js') }}"></script>

  <script>
    $(document).ready(function(){

    });

  </script>
@endsection
