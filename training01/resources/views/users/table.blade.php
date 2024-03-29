<div id="table_component">
  <div class="row ">
    <div class="d-flex justify-content-around  align-items-center">
      <div id="pagi" class="col-8 d-flex justify-content-center">
        {{-- {!! $users->links() !!} --}}
        {{ $users->links() }}
      </div>
      <div class="col-4 text-center  d-flex  align-items-center">
        @php
        // dd($users);
        $i = $users->currentPage()*$users->perPage() - $users->perPage() + 1 ;   
        @endphp
        Hiển thị từ {{$i}} ~ 
        {{$users->currentPage()==$users->lastPage() ? $i - 1  + $users->total()%$users->perPage() :$i + $users->perPage() -1 }}
         trong tổng số {{$users->total()}} User!

      </div>
    </div>
  </div>
  <div class="table-responsive text-nowrap  ">
    <table class="table">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Họ tên</th>
          <th>Email</th>
          <th>Nhóm</th>
          <th>Trạng thái</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="tbody-table" class="table-border-bottom-0">
        @if ( !($users->isEmpty()))
          @foreach ($users as $index => $user)
            <tr>
              <td><strong> {{ $i++ }} </strong></td>
              <td><i class="text-danger me-3"></i> <strong> {{ $user->name }} </strong></td>
              <td> {{ $user->email }} </td>
              <td> {{ $user->group_role }} </td>
              @if ($user->is_active == 1)
                <td> <span class="text-primary me-1">Đang hoạt động</span></td>
              @elseif($user->is_active == 0)
                <td> <span class="text-danger me-1">Tạm khóa</span></td>
              @endif

              <td><button class="edit btn" data-id= "{{ $user->id }}" data-name= "{{ $user->name }}" data-email="{{ $user->email }}" data-group="{{ $user->group_role }}"
                  data-is_active="{{ $user->is_active }}" data-bs-toggle="modal" data-bs-target="#FormUserModel"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="#0b08aa"
                      d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                  </svg></button>
                <button class="delete btn" data-id= "{{ $user->id }}" data-name= "{{ $user->name }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#ff0000"
                      d="M7.615 20q-.67 0-1.143-.472Q6 19.056 6 18.385V6H5V5h4v-.77h6V5h4v1h-1v12.385q0 .69-.462 1.152q-.463.463-1.153.463zM17 6H7v12.385q0 .269.173.442t.442.173h8.77q.23 0 .423-.192q.192-.193.192-.423zM9.808 17h1V8h-1zm3.384 0h1V8h-1zM7 6v13z" />
                  </svg></button>
                <button class="lock btn" data-id= "{{ $user->id }}" data-name= "{{ $user->name }}" data-is_active="{{ $user->is_active }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="black"
                      d="M6 22q-.825 0-1.412-.587T4 20V10q0-.825.588-1.412T6 8h1V6q0-2.075 1.463-3.537T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.587 1.413T18 22zm0-2h12V10H6zm6-3q.825 0 1.413-.587T14 15q0-.825-.587-1.412T12 13q-.825 0-1.412.588T10 15q0 .825.588 1.413T12 17M9 8h6V6q0-1.25-.875-2.125T12 3q-1.25 0-2.125.875T9 6zM6 20V10z" />
                  </svg></button>
              </td>
            </tr>
          @endforeach
        @else
          <tr style="text-align: center">
            <td colspan="6">Không có dữ liệu</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div id="pagi" class="col d-flex justify-content-center">
    {{ $users->links() }}
  </div>
</div>
