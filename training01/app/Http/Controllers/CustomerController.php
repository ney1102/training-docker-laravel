<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Maatwebsite\Excel\Facades\Excel;
class CustomerController extends Controller
{
    //index
    public function index(Request $request){
        $data = $request->all();

        $response = ['success' => false, 'data' => [], 'message' => ''];

        $customers = Customer::select('customer_id','customer_name', 'email', 'tel_num', 'address');
        // dd($customers);  
        if ($request->filled('c_name')) {
            $customers->where('customer_name', 'like', '%' . $data['c_name'] . '%');
        }
        if ($request->filled('c_email')) {
            $customers->where('email', 'like', '%' . $data['c_email'] . '%');
        }
        if ($request->filled('c_address')) {
            $customers->where('address','like', '%'. $data['c_address'] . '%');
        }
        if ($request->filled('c_is_active')) {
            $customers->where('is_active', $data['c_is_active']);
        }
        $customers = $customers->orderBy('customer_id', 'desc')->paginate(20);
        // dd($customers);
        if (request()->ajax()) {
            
            if (!$customers->isEmpty()) {
                $table = view('customers.table', ['customers' => $customers])->render();
                $paginate = $customers->links()->toHTML();
                return response()->json(['html' => $table, 'pagination' => $paginate]);
            }
            else { 
                $table = view('customers.table', ['customers' => $customers])->render();
                $paginate = $customers->links()->toHTML();
                return response()->json(['html' => $table, 'pagination' => $paginate]);
            }
        }
        return view('customers.index', ['customers' => $customers]);
    }
    public function Create(Request $request){
        $data = $request->all();
        $response = ['success' => false];
        $messageErrors = [
            'customer_name.required' => 'Vui lòng nhập tên khách hàng',
            'customer_name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được đăng ký',
            'email.email' => 'Email không đúng định dạng',
            'address.required' => 'Địa chỉ không được để trống',
            'tel_num.required' => 'SĐT không được để trống',
            'tel_num.regex' => 'Nhập không đúng định dạng SĐT'
            
        ];
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|min:5',
            'email' => 'required|unique:mst_customer|email:rfc',
            'address' => 'required',
            'tel_num' =>'required|regex:/^[0-9]{10,11}$/',            
        ], $messageErrors);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['success'] = false;
            $response['Errors'] = $errors;
            return response()->json($response);
        }
        $newCustomer= [
            'customer_name' => $data['customer_name'],
            'email' => $data['email'],
            'address' =>$data['address'],
            'tel_num' => $data['tel_num'],
            'is_active' => $request->has('is_active') ? $request->get('is_active'):0,            
            'created_at' => NOW(),
        ];
        $result = Customer::create($newCustomer);
        if($result){
            $response['success'] = true;
        }
        return response()->json($response);
    }
    public function Update(Request $request)
    {
        $data = $request->all();
        $response = ['success' => false,'Errors'=>[]];
        $messageErrors = [
            'customer_name.required' => 'Vui lòng nhập tên khách hàng',
            'customer_name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được đăng ký',
            'email.email' => 'Email không đúng định dạng',
            'address.required' => 'Địa chỉ không được để trống',
            'tel_num.required' => 'SĐT không được để trống',
            'tel_num.regex' => 'Nhập không đúng định dạng SĐT',
            
        ];
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|min:5',
            'email' => ['required', Rule::unique('mst_users')->ignore($data['customer_id']), 'email:rfc'],
            'address' => 'required',
            'tel_num' => 'required|regex:/^[0-9]{10,11}$/',
        ], $messageErrors);
        if ($validator->fails()) {
            $response['Errors'] = $validator->errors();
            return response()->json($response);
        }
        if (!empty ($request->input('customer_id'))) {
            $customer = Customer::where('customer_id',(int)$request->input('customer_id'))->first();
            // dd($request->input('customer_id'),$customer);
            if ($customer) {
                $customer['customer_name'] = $request->input('customer_name');
                $customer['email'] = $request->input('email');
                $customer['tel_num'] = $request->input('tel_num');
                $customer['address'] = $request->input('address');
                $customer['updated_at']= now();
            }
            $result = $customer->save();
            if ($result) {
                $response['success'] = true;
            }
            return response()->json($response);

        }
    }
    public function export(Request $request){
        $data = $request->all();
        $c_name = $request->input('c_name');
        $c_email = $request->input('c_email');
        $c_address = $request->input('c_address');
        $c_is_active = $request->input('c_is_active');
        $customers = Customer::select('customer_id','customer_name', 'email', 'tel_num', 'address');
        // dd($customers);  
        if ($request->filled('c_name')) {
            $customers->where('customer_name', 'like', '%' . $data['c_name'] . '%');
        }
        if ($request->filled('c_email')) {
            $customers->where('email', 'like', '%' . $data['c_email'] . '%');
        }
        if ($request->filled('c_address')) {
            $customers->where('address','like', '%'. $data['c_address'] . '%');
        }
        if ($request->filled('c_is_active')) {
            $customers->where('is_active', $data['c_is_active']);
        }
        $customers = $customers->orderBy('customer_id', 'desc')->limit(20)->get();
    
        // Đưa các tham số này vào hàm export hoặc làm bất kỳ điều gì bạn muốn với chúng
    
        // dd($customers);
        return Excel::download(new CustomerExport($customers),'customer.xlsx');
    }
    public function import(Request $request){
        $import = new CustomersImport;
        // Excel::toCollection($import, $request->file('customer-file'));      
        $result = Excel::import($import, $request->file('customer-file'));
        if($result){

            view('customers.index', ['success' => 'Import thành công']);
        }
        return back();
    }
}