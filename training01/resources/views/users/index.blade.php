@extends('dashboard')
@section('content')
  <div class="card" style="margin-top: 35px">
    <h5 class="card-header">User</h5>
    <div class="col">
      <form  id="user_search">
        <div class="row p-3">
            <input type="hidden" id="u-page" value="" name="page" value="{{$request['page']}}">
            <div class="col-3">
              <label for="s-name" class="form-label"><strong>Tên</strong></label>
              <input type="text" name="s_name" id="s-name" class="form-control" placeholder="Nhập họ tên" value="{{$request['s_name'] ? $request['s_name'] : ''}}">
            </div>
            <div class="col-3">
              <label for="s-email" class="form-label"><strong>Email</strong></label>
              <input type="text" name="s_email" id="s-email" class="form-control" placeholder="Nhập Email" value="{{$request['s_email'] ? $request['s_email'] : ''}}">
            </div>
            <div class="col-3">
              <label for="s-group" class="form-label"><strong>Nhóm</strong></label>
              <select type="text" class="form-select" id="s-group" name="s_group" value="{{$request['s_group_role'] ? $request['s_group_role'] : ''}}">
                <option selected="" disabled value="">Chọn nhóm</option>
                <option value="editor">Editor</option>
                <option value="reviewer">Reviewer</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          <div class="col-3">
            <label for="s-is_active" class="form-label"><strong>Trạng Thái</strong></label>
            <select type="text" class="form-select" id="s-is_active" name="s_is_active"  value="{{$request['s_is_active'] ? $request['s_is_active'] : ''}}">
              <option selected disabled value=''>Chọn trạng thái</option>
              <option value=1>Đang hoạt động</option>
              <option value=0>Tạm khóa</option>
            </select>
          </div>
        </div>
        <div class="row pb-3  ">
          <div class="col-5 d-flex">
            <div class="" style="border: 1px solid #0b5ed7; border-radius: 8px;">
              <label class="ps-2" for="create-user"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 640 512"><path fill="#0b5ed7" d="M96 128a128 128 0 1 1 256 0a128 128 0 1 1-256 0M0 482.3C0 383.8 79.8 304 178.3 304h91.4c98.5 0 178.3 79.8 178.3 178.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3M504 312v-64h-64c-13.3 0-24-10.7-24-24s10.7-24 24-24h64v-64c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h-64v64c0 13.3-10.7 24-24 24s-24-10.7-24-24"/></svg></label>
              <a class="btn btn-primary create" id="create-user" href="#" data-bs-toggle="modal" data-bs-target="#FormUserModel"> Thêm mới</a>
            </div>
          </div>
          <div class="col-3"></div>
          <div class="col-4 d-flex justify-content-between">
              <div class=" d-flex  align-items-center " style="border: 1px solid #0b5ed7; border-radius: 8px;">
                <label for="u_search" class="px-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#0b5ed7" d="M10.5 2a8.5 8.5 0 1 0 5.262 15.176l3.652 3.652a1 1 0 0 0 1.414-1.414l-3.652-3.652A8.5 8.5 0 0 0 10.5 2M4 10.5a6.5 6.5 0 1 1 13 0a6.5 6.5 0 0 1-13 0"/></g></svg>
                </label>
                <button id="u-search" class="btn btn-primary search" type="submit" >Tìm kiếm</button>
              </div>
              <div class="   d-flex  align-items-center " style="border: 1px solid #157347; border-radius: 8px;">
                <label for="clear-search" class="pe-2"><svg class=" ms-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#157347" d="m12 14.122l5.303 5.303a1.5 1.5 0 0 0 2.122-2.122L14.12 12l5.304-5.303a1.5 1.5 0 1 0-2.122-2.121L12 9.879L6.697 4.576a1.5 1.5 0 1 0-2.122 2.12L9.88 12l-5.304 5.304a1.5 1.5 0 1 0 2.122 2.12z"/></g></svg></label>
                <button id="clear-search" class="btn btn-success clear-search">Xóa tìm </button>
              </div>
          </div>
        </div>        
      </form>
        <!-- Modal -->
    <div class="modal fade" id="FormUserModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="form-user" action="" method="post">
            @csrf
            <div class="modal-body">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Tên</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="hidden" id="u-id" name="id" value="" />
                    <input type="text" class="form-control" id="u-name" name="name" placeholder="Nhập họ tên" aria-describedby="basic-icon-default-fullname2" />
                  </div>
                  <div class="message-error name text-danger"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Email</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="text" class="form-control " id="u-email" name="email" placeholder="Nhập Email" aria-describedby="basic-icon-default-fullname2" />
                  </div>
                  <div class="message-error email text-danger"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Mật khẩu</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="password" class="form-control" id="u-password" name="password" placeholder="Mật khẩu" aria-describedby="basic-icon-default-fullname2" />
                  </div>
                  <div class="message-error password text-danger"></div>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Xác nhận mật khẩu</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <input type="password" class="form-control" id="u-repassword" name="repassword" placeholder="Xác nhận mật khẩu" aria-describedby="basic-icon-default-fullname2" />
                  </div>
                  <div class="message-error repassword text-danger"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Nhóm</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <select class="form-select group_role" id="u-group" name="group_role">
                      <option value="" selected disabled>Chọn nhóm</option>
                      <option value="editor">Editor</option>
                      <option value="reviewer">Reviewer</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                  <div class="message-error group_role text-danger"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Trạng thái</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-merge">
                    <div class="form-check form-check-inline">
                      <input type="checkbox" class="form-check-input u-is-active" id="active" name="is_active" value=1>
                      <label class="form-check-label text-primary " for="flexCheckDefault">Đang hoạt động</label>
                    </div>
                  </div>
                  <div class="message-error is-active text-danger"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btn-close" class="btn btn-secondary " data-bs-dismiss="modal">Hủy</button>
              <button type="button" id="btn-save" class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @include('users.table')  
    </div>
  </div>
  </div>
  <script>
    const token = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
      // get conditions searching
      function getValueInputSearch() {
        return {
          name: $('#s-name').val(),
          email: $('#s-email').val(),
          group_role: $('#s-group').val(),
          is_active: $('#s-is_active').val(),
					page: $('#s-page').val()
        }
      }
			function LoadValuesInputSearch() {
				param = new URLSearchParams(window.location.search);
				const s_name = param.get( 's_name' ) ;
				const s_email = param.get( 's_email' ) ;
				const s_group = param.get( 's_group' ) ;
				const s_is_active = param.get( 's_is_active' ) ;
				const page = param.get( 'page' ) ;
				$('#s-name').val(s_name);
				$('#s-email').val(s_email);
        $('#s-group').val(s_group);
        $('#s-is_active').val(s_is_active).change();
				$('page').val(page);
			}
			LoadValuesInputSearch();
      function LoadTable(url) {
        event.preventDefault();
        conditions = getValueInputSearch();
        conditions.name = conditions.name !== undefined && conditions.name !== null ? conditions.name : '';
        conditions.email = conditions.email !== undefined && conditions.email !== null ? conditions.email : '';
        conditions.group_role = conditions.group_role !== undefined && conditions.group_role !== null ? conditions.group_role : '';
        conditions.is_active = conditions.is_active !== undefined && conditions.is_active !== null ? conditions.is_active : '';
        urlWithParam = `/users/load?s_name=${conditions.name}&s_email=${conditions.email}&s_group_role=${conditions.group_role}&s_is_active=${conditions.is_active}`;
        if(url!=null){
          history.replaceState(null, null, url);
        }else{
          history.replaceState(null, null, urlWithParam);
        }
        $.ajax({
          url:  url || urlWithParam,
          method: 'GET',
          dataType: 'json',
          data: {
            s_name: conditions.name,
            s_email: conditions.email,
            s_group_role: conditions.group_role,
            s_is_active: conditions.is_active
          },
          success: function(data) {
            $('#table_component').empty();
						$('#table_component').append(data.html);	
						$('#pagi').empty();
						$('#pagi').append(data.pagination)

            if  ( data.success==false ) {
              const row = '<tr style="text-align: center"> <td colspan="6">Không có dữ liệu</td></tr>';
              $('#tbody-table').append(row);
            }
          },
          error: function() {

          }
        });
      }

      function ClearForm() {
        $('#u-id').val('');
        $('#u-name').val('');
        $('#u-email').val('');
        $('#u-group').val('').change();
        $('#u-password').val('');
        $('#u-repassword').val('');
        $('.u-is-active').prop('checked', true);
        $('#exampleModalLabel').text("")
      };

      function ClearValidate() {
        // $('#FormUserModel').removeAttr('role');
        // $('#FormUserModel').removeClass('show');
        // $('#FormUserModel').css('display', 'none');
        $('#u-name').removeClass('is-invalid');
        $('#u-email').removeClass('is-invalid');
        $('#u-password').removeClass('is-invalid');
        $('#u-repassword').removeClass('is-invalid');
        $('#u-group').removeClass('is-invalid');
        $('.message-error').text('');
      }

      function LoadData(id = '', name = '', email = '', group, is_active, title) {
        $('#u-id').val(id)
        $('#u-name').val(name ?? '');
        $('#u-email').val(email ?? '');
        $('#u-group').val(group).change();
        if (is_active == 1) {
          $('.u-is-active').prop('checked', true);
        } else if (is_active == 0) {
          $('.u-is-active').prop('checked', false);
        }
        $('#exampleModalLabel').text(title ?? "")
      };

      function getValueInput() {
        let id = $('#u-id').val();
        let name = $('#u-name').val();
        let email = $('#u-email').val();
        let password = $('#u-password').val();
        let repassword = $('#u-repassword').val();
        let group = $('#u-group').val();
        let active =( $('.u-is-active:checked').val()!= undefined ? $('.u-is-active:checked').val() : 0);
        return {
          id: id,
          name: name,
          email: email,
          password: password,
          repassword: repassword,
          group: group,
          active: active
        };
      }
      //when click edit icon
      $(document).on("click", ".edit", function() {
        ClearValidate();
        let id = $(this).data('id');
        let name = $(this).data('name');
        let email = $(this).data('email');
        let group = $(this).data('group');
        console.log(group);
        let is_active = $(this).data('is_active');
        let title = "Chỉnh sửa User";
        ClearForm();
        data = [id, name, email, group, is_active, title]
        LoadData(...data);
        // $('#FormUserModel').removeClass('hidden');
      });
      //when click create btn
      $(document).on("click", ".create", function() {
        event.preventDefault();
        ClearValidate();
        // $('#FormUserModel').modal('show');
        let title = "Thêm mới User";
        ClearForm();
        LoadData('', '', '', '', 1, title);
      });
      //when click save btn
      $(document).on("click", "#btn-save", function() {
        data = getValueInput();
        console.log(data.active);
        user = new FormData();
        user.append('id',data.id);
        user.append('name',data.name);
        user.append('password',data.password);
        user.append('repassword',data.repassword);
        user.append('group_role',data.group==null ? '' : data.group);
        user.append('email',data.email);
        user.append('is_active',data.active);
        console.log(user);
        $.ajax({
          url: "/users/save",
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token
          },
          data: user,
          dataType: 'json',
          cache: false,
            contentType: false,
            processData: false,
          success: function(response) {
            ClearValidate();
            console.log(response);
            if (!response.success && response.Errors != null) {
              //error name
              if (response.Errors.hasOwnProperty('name')) {
                $('.message-error.name').text(response.Errors.name[0]);
                $('#u-name').addClass('is-invalid');               
              }
              //error email
              if(response.Errors.hasOwnProperty('email')){
                $('.message-error.email').text(response.Errors.email[0]);
                $('#u-email').addClass('is-invalid');
              }
              //error password
              if (response.Errors.hasOwnProperty('password')) {
                $('.message-error.password').text(response.Errors.password[0]);
                $('#u-password').addClass('is-invalid');
              }
              //error confirm password
              if (response.Errors.hasOwnProperty('repassword')) {
                $('#u-repassword').addClass('is-invalid');
                console.log(response.Errors.repassword[0]);
                $('.message-error.repassword').text(response.Errors.repassword[0]);
              }
              //error group_role
              if (response.Errors.hasOwnProperty('group_role')) {
                $('#u-group').addClass('is-invalid');
                $('.message-error.group_role').text(response.Errors.group_role[0]);
              }
            }
            //successfuly
            if (response.success) {
              $('.toast-body').text(response.message);
              // $('#notification').removeClass('hide');
              // $('#notification').addClass('show');
              $('.btn-close').click();
              $('#tbody-table').empty();
              if (data.id != 0 || data.id != null) {
                LoadTable()
              }else{
                LoadTable('/users/load')
              }
            }
          },
          error: function() {}
        });
      });
      //when click close btn
      $(document).on("click", ".btn-close", function() {
        ClearValidate();
        // $('#FormUserModel').modal('hide');
      });
      //when click delete btn
      $(document).on("click", ".delete", function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        if (confirm(`Bạn có muốn xóa user: ${name} không?`)) {
          $.ajax({
            url: "/users/delete",
            type: 'DELETE',
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': token
            },
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (!response.success) {
                alert(response.message);
              }
              //successfuly
              if (response.success) {
                LoadTable();
              }
            },
            error: function() {}
          });
        }
      });
      //when click lock btn
      $(document).on('click', '.lock', function() {
        let id = $(this).data('id');
        let is_active = $(this).data('is_active');
        let name = $(this).data('name');
        if (confirm('Bạn có muốn ' + ((is_active ?? 1) ? 'KHÓA' : 'MỞ KHÓA') + ' User ' + name + ' không?')) {
          $.ajax({
            url: "/users/toggle-status-user",
            type: 'PUT',
            method: 'PUT',
            headers: {
              'X-CSRF-TOKEN': token
            },
            data: {
              id: id,
              is_active: is_active
            },
            dataType: 'json',
            success: function(response) {
              if (!response.success) {
                alert(JSON.stringify(response.message));
              }
              //successfuly
              if (response.success) {
                LoadTable();

              }
            },
            error: function() {}
          });
        }
      });
      //when click search btn
      $(document).on('click', '.search', function() {
				event.preventDefault();
        LoadTable();
      });
      //when click pagination item
      $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        const myurl = $(this).attr('href');
				conditions = getValueInputSearch();
        conditions.name = conditions.name !== undefined && conditions.name !== null ? conditions.name : '';
        conditions.email = conditions.email !== undefined && conditions.email !== null ? conditions.email : '';
        conditions.group_role = conditions.group_role !== undefined && conditions.group_role !== null ? conditions.group_role : '';
        conditions.is_active = conditions.is_active !== undefined && conditions.is_active !== null ? conditions.is_active : '';
				newUrl = `${myurl}&s_name=${conditions.name}&s_email=${conditions.email}&s_group_role=${conditions.group_role}&s_is_active=${conditions.is_active}`;
        console.log(newUrl);
        // var page = $(this).attr('href').split('page=')[1];
        // $(this).attr('href', newUrl);
        LoadTable(newUrl);
      });
      //when click clear search btn
      $('.clear-search').on('click', function() {
				event.preventDefault();
          $('#s-name').val(''),
          $('#s-email').val(''),
          $('#s-group').val(''),
          $('#s-is_active').val(''),
          LoadTable('/users/load');
      });
      $(document).on('submit','#user_search', function(e){
        e.preventDefault();
      })
    });
  </script>
@endsection
