<style>
    .hidden{display: none;}
</style>
<div id="table-customer" class="row ">
  <div class="d-flex justify-content-around  align-items-center">
    <div id="pagi" class="col-8 d-flex justify-content-center">
      {{ $customers->links() }}
    </div>
    <div class="col-4 text-left">
      <p>
        @php
        $i = $customers->currentPage()*$customers->perPage() - $customers->perPage() + 1   ; // Giả sử bạn muốn bắt đầu từ 1
        @endphp
        Hiển thị từ {{$i}} ~ {{$customers->currentPage()==$customers->lastPage() ? $i - 1  + $customers->total()%$customers->perPage() :$i + $customers->perPage() -1 }} trong tổng số {{$customers->total()}} khách hàng

      </p>
    </div>
  </div>
  <table class="table">
    <thead class="table-dark">
      <tr>
        <th style="width: 5%"">#</th>
        <th style="width: 15%">Họ và tên</th>
        <th style="width: 25%">Email</th>
        <th>Địa chỉ</th>
        <th style="width: 14%" >Số điện thoại</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tbody id="table-tbody">
      @if (!($customers->isEmpty()))
        @foreach ($customers as $index => $value)
          <tr id="cus-{{ $value->customer_id }}" class="cus-{{ $value->customer_id }}">
            <td>{{ $i++ }}</td>
            <td id="c_name_{{ $value->customer_id }}">{{ $value->customer_name }}</td>
            <td id="c_email_{{ $value->customer_id }}">{{ $value->email }}</td>
            <td id="c_address_{{ $value->customer_id }}">{{ $value->address }}</td>
            <td class="" id="c_tel_num_{{ $value->customer_id }}">{{ $value->tel_num ? $value->tel_num : '' }}</td>
            <td class="text-center">
              <a id="c_edit{{ $value->customer_id }}" class="c_edit text-decoration-none" data-id= "{{ $value->customer_id }}" data-name= "{{ $value->customer_name }}" data-email="{{ $value->email }}" data-tel_num="{{ $value->tel_num }}" data-address="{{$value->address}}" data-
                data-is_active="{{ $value->is_active }}" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="#0b08aa"
                    d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                </svg>
              </a>
              <a id="c_save_edit_{{$value->customer_id}}"  class="c_save_edit text-decoration-none hidden" data-id= "{{ $value->customer_id }}" data-name= "{{ $value->customer_name }}" data-email="{{ $value->email }}" data-tel_num="{{ $value->tel_num }}" data-address="{{$value->address}}" data-
                data-is_active="{{ $value->is_active }}" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#00f531" d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15q0-1.25-.875-2.125T12 12q-1.25 0-2.125.875T9 15q0 1.25.875 2.125T12 18m-6-8h9V6H6z"/></svg>
              </a>
              <a id="c_cancel_edit_{{$value->customer_id}}" class="c_cancel_edit text-decoration-none hidden" data-id= "{{ $value->customer_id }}" data-name= "{{ $value->customer_name }}" data-email="{{ $value->email }}" data-tel_num="{{ $value->tel_num }}" data-address="{{$value->address}}" data-
                data-is_active="{{ $value->is_active }}" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#ff0000" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6zm3.6 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22"/></svg>
              </a>
            </td>
          </tr>
        @endforeach
      @else
      <tr style="text-align: center"> <td colspan="6">Không có dữ liệu</td></tr>
      @endif
    </tbody>
  </table>
  <div id="pagi" class="col d-flex justify-content-center">
    {{-- {!! $products->links() !!} --}}
    {{ $customers->links() }}
  </div>
</div>

