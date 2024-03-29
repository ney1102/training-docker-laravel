<div id="table_component">
  <div class="row ">
    <div class="d-flex justify-content-around">
      <div id="pagi" class="col-8 d-flex justify-content-center">
        {{-- {!! $products->links() !!} --}}
        {{ $products->links() }}
      </div>
      <div class="col-4 text-left">
        @php
          $i = $products->currentPage() * $products->perPage() - $products->perPage() + 1; // Giả sử bạn muốn bắt đầu từ 1
        @endphp
        Hiển thị từ {{ $i }} ~ {{ $products->currentPage() == $products->lastPage() ? $i - 1 + ($products->total() % $products->perPage()) : $i + $products->perPage() - 1 }} trong tổng số
        {{ $products->total() }} sản phẩm
      </div>
    </div>
  </div>
  <div class="table-responsive text-nowrap    ">
    <table class="table ">
      <thead class="table-dark ">
        <tr>
          <th  style="width: 4%;"class="text-start">#</th>
          <th style="width: 15%;">Tên sản phẩm</th>
          <th style="width: 40%;">Mô tả</th>
          <th>Giá</th>
          <th class="text-center" style="width: 15%;">Tình trạng</th>
          <th class="text-center"></th>
        </tr>
      </thead>
      <tbody id="tbody-table" class="table-border-bottom-0 ">

        @if (!$products->isEmpty())
          @foreach ($products as $index => $value)
            <tr class="align-middle">
              <td><strong> {{ $i++ }} </strong></td>
              <td class="td_product_name " data-id="{{ $value->product_id }}">
                <strong> {{ $value->product_name }}
                </strong>
                @if ($value->product_image != null)
                  <div class="text-center">
                    <img id="img-{{ $value->product_id }}" src="{{ asset($value->product_image) }}" style=" height: 150px; width:230px;" class="rounded hidden" alt="">
              </td>
  </div>
  @endif

  <td  data-urlImg="{{ asset($value->product_image) }}"><span class="d-inline-block text-truncate" style="max-width: 350px;">{{ $value->description }}</span> </td>
  <td> ${{ $value->product_price }} </td>
  <td class="text-center">
    @if ((int) $value->is_sales == 1)
      <span class="text-primary me-1">Đang bán</span>
    @elseif((int) $value->is_sales == 0)
      <span class="text-warning me-1">Ngừng bán</span>
    @elseif((int) $value->is_sales == 2)
      <span class="text-danger me-1">Hết hàng</span>
    @endif
  </td>

  <td class="text-center">
    <a class="p_edit  text-decoration-none" data-bs-toggle="modal" data-bs-target="#FormProduct" data-id= "{{ $value->product_id }}" data-name="{{ $value->product_name }}"
      data-price="{{ $value->product_price }}" data-img="{{ $value->product_image }}" data-is_sales="{{ $value->is_sales }}" data-description="{{ $value->description }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="#0b08aa" d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
      </svg>
    </a>
    <a class="p_delete btn text-decoration-none" data-id= "{{ $value->product_id }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="#ff0000" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
      </svg>
    </a>

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
  {{-- {!! $products->links() !!} --}}
  {{ $products->links() }}
</div>
</div>

<script>
  $(document).ready(function() {
    function hoverLoadImg() {
      $(".td_product_name").hover(
        function() {
          const id = $(this).data("id");
          $(this).find(`#img-${id}`).removeClass("hidden");
        },
        function() {
          const id = $(this).data("id");
          //let url = $(this).find("img.rounded").attr("src");
          $(this).find(`#img-${id}`).addClass("hidden");
        }
      );
    }
    hoverLoadImg();
  })
</script>
