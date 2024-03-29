<table>
    <thead>
    <tr height="50">
        <th  colspan=5 valign="center" style="text-align:center;font-size: 18px; font-weight:bold">Danh sách export Khách hàng</th>
        
    </tr>
    <tr height=30 >
        <th valign="center" width=15 style="text-align:center;font-size: 16px; font-weight:500">STT</th>
        <th valign="center" width=30 style="text-align:center;font-size: 16px; font-weight:500">Tên khách hàng</th>
        <th valign="center" width=30 style="text-align:center;font-size: 16px; font-weight:500">Email</th>
        <th valign="center" width=30 style="text-align:center;font-size: 16px; font-weight:500">Số điện thoại</th>
        <th valign="center" style="text-align:center;font-size: 16px; font-weight:500" width=80>Địa chỉ</th>
    </tr>
    </thead>
    <tbody> 
    @if (!($customers->isEmpty()))
        @foreach($customers as $index => $value)
        <tr height=25>
            <th valign="center"  style="font-size: 14px; font-weight:200">{{ $index+1 }}</th>
            <td valign="center"  style="font-size: 14px; font-weight:200">{{ ($value->customer_name) ? $value->customer_name : '' }}</td>
            <td valign="center"  style="font-size: 14px; font-weight:200">{{ ($value->email) ? $value->email : '' }}</td>
            <td valign="center"  style="font-size: 14px; font-weight:200">{{ ($value->tel_num) ? $value->tel_num : '' }}</td>
            <td valign="center" style="font-size: 14px; font-weight:200">{{ ($value->address) ? $value->address : '' }}</td>
        </tr>
        @endforeach
    @else
    <tr style="text-align: center" > <td colspan=5 height=25 valign="center" width=30 style="text-align:center;font-size: 14px; font-weight:200">Không có dữ liệu</td></tr>
    @endif
    </tbody>
</table>
