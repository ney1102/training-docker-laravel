<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class CustomersImport implements ToModel, WithHeadingRow,WithValidation
{

    public function headingRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        // dd($row);
        return new Customer([
            'customer_name' => $row['ten_khach_hang'],
            'email' => $row['email'],
            'tel_num' => $row['so_dien_thoai'],
            'address' => $row['dia_chi'],
        ]);
    }
    public function rules(): array
    {
        return [
            'ten_khach_hang' => 'required|min:5',
            'email' => 'required|unique:mst_customer,email|email:rfc',
            'dia_chi' => 'required',
            'so_dien_thoai' => 'required|regex:/^[0-9]{10,11}$/',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'ten_khach_hang.required' => 'Vui lòng nhập tên khách hàng',
            'custoten_khach_hangmer_name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được đăng ký',
            'email.email' => 'Email không đúng định dạng',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'so_dien_thoai.required' => 'SĐT không được để trống',
            'so_dien_thoai.regex' => 'Nhập không đúng định dạng SĐT',            
        ];
    }
    

}
