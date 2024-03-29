<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    protected $m_users;
    public function __construct(Users $users)
    {
        $this->users = $users;
    }
    public function index()
    {
        return view('users.index');
    }
    public function LoadUsers(Request $request)
    {
        $data = $request->all();

        $response = ['success' => false, 'data' => [], 'message' => ''];

        $users = Users::select('id', 'name', 'email', 'group_role', 'is_active')->where('is_delete', 0);

        if ($request->filled('s_name')) {
            $users->where('name', 'like', '%' . $data['s_name'] . '%');
        }
        if ($request->filled('s_email')) {
            $users->where('email', 'like', '%' . $data['s_email'] . '%');
        }
        if ($request->filled('s_group_role')) {
            $users->where('group_role', $data['s_group_role']);
        }
        if ($request->filled('s_is_active')) {
            $users->where('is_active', $data['s_is_active']);
        }
        $users = $users->orderBy('id', 'desc')->paginate(20);

        $requestOld = [
            's_name' => isset ($data['s_name']) ? $data['s_name'] : "",
            's_email' => isset ($data['s_email']) ? $data['s_email'] : "",
            's_group_role' => isset ($data['s_group_role']) ? $data['s_group_role'] : "",
            's_is_active' => isset ($data['s_is_active']) ? $data['s_is_active'] : "",
            'page' => isset ($data['page']) ? $data['page'] : ""
        ];
        if (request()->ajax()) {
                $table = view('users.table', ['users' => $users])->render();
                $paginate = $users->links()->toHTML();
                return response()->json(['html' => $table, 'pagination' => $paginate]);
        }
        return view('users.index', ['users' => $users, 'request' => $requestOld]);
       
    }
    public function SaveUsers(Request $request)
    {
        $data = $request->input();
        $response = ['success' => false, 'data' => [], 'message' => ''];
        // update users

        if (isset($data['id'])) {
            
            $messageErrors = [
                'name.required' => 'Tên  không được để trống',
                'name.min'=>'Tên phải lớn hơn 5 ký tự',
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email đã được đăng ký',
                'email.email' => 'Email không đúng định dạng', 
                'password.min' => 'Mật khẩu phải lớn hơn 5 kí tự',
                'password.regex' => 'Mật khẩu không bảo mật',                
                'repassword.same' => 'Mật khẩu và Xác nhận mật khẩu không chính xác',
                'group_role'=> 'Chưa chọn quyền cho User'
            ];
            $rules =  [
                'name' => 'required|min:5',
                'email' => ['required', Rule::unique('mst_users')->ignore($data['id']),'email:rfc'],
                'repassword' => 'same:password',
                'group_role' => 'required',
            ];
            if (!empty($request->input('password'))) {
                $rules['password'] = 'min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,}$/';
            }
            $validator = Validator::make($request->all(),$rules, $messageErrors);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $response['success'] = false;
                $response['message'] = 'Chỉnh sửa user không thành công';
                $response['Errors'] = $errors;
                return response()->json($response);
            }
            $editUser = Users::find($data['id']);
            if ($editUser) {
                $editUser->name = $data['name'];
                $editUser->email = $data['email'];
                $editUser->group_role = $data['group_role'];
                $editUser->is_active = $request->has('is_active') ? $data['is_active'] : 0;
                $editUser->updated_at = now();
                if (!empty ($data['password'])) {
                    $editUser->password = Hash::make($data['password']);
                }
                $editUser->save();
                $response['success'] = true;
                $response['message'] = "Chỉnh sửa user " . $editUser->name . " thành công";
            }
            return response()->json($response);

        }
        //add user
        else if ($request->input('id') == null || $request->input('id') == '') {
            $messageErrors = [
                'name.required' => 'Tên không được để trống',
                'name.min'=>'Tên phải lớn hơn 5 ký tự',
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email đã được đăng ký',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Mật khẩu không được để trống',
                'group_role.required' => 'Chưa chọn quyền cho User',
                'password.min' => 'Mật khẩu phải lớn hơn 5 kí tự',
                'password.regex' => 'Mật khẩu không bảo mật',                
                'repassword.same' => 'Mật khẩu và Xác nhận mật khẩu không chính xác',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'email' => 'required|unique:mst_users|email:rfc',
                'password' => 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,}$/',
                'repassword' => 'same:password',
                'group_role' => 'required',
            ], $messageErrors);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $response['success'] = false;
                $response['message'] = 'Lưu thất bại';
                $response['Errors'] = $errors;
                return response()->json($response);
            }
            $newUser = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'group_role' => $data['group_role'],
                'is_active' => $request->has('is_active') ? $data['is_active'] : 0,
                'is_delete' => 0,
                'create_at' => NOW(),
            ];
            $result = Users::create($newUser);
            if ($result) {
                $response['success'] = true;
                $response['message'] = "Thêm mới user thành công";
            }
            return response()->json($response);
        }
    }
    public function DeleleUserAjax(Request $request)
    {
        $data = $request->all();
        $response = ['success' => false, 'data' => [], 'message' => ''];
        try {
            // check id
            if (!empty ($data['id']) && isset ($data['id'])) {
                $user = Users::find($request->input('id'));
                $user->is_delete = 1;
                $result = $user->save();
                // check deleted user
                if ($result) {
                    $response['success'] = true;
                    $response['message'] = "Xóa User " . $user->name . " thành công!";
                } else {
                    $response['message'] = "Đã có lỗi khi xóa User " . $user->name . ", vui lòng thử lại!";
                }
            }
            //if Id not exist 
            else {
                $response['message'] = "Không tìm thấy User, vui lòng thử lại!";
            }
        } catch (\Throwable $th) {
            $response['message'] = $th;

        }
        return response()->json($response);
    }
    public function ToggleLockStatusUserAjax(Request $request)
    {
        $data = $request->all();//dd($request->all());
        $response = ['success' => false, 'data' => [], 'message' => ''];
        try {
            // check id
            if (!empty ($data['id']) && isset ($data['id'])) {
                $user = Users::find($request->input('id'));
                if ($user) {
                    if ($data['is_active'] == 1) {
                        $user->is_active = 0;
                        ($user->save()) ? $response['success'] = true : false;
                    }
                    if ($data['is_active'] == 0) {
                        $user->is_active = 1;
                        ($user->save()) ? $response['success'] = true : false;
                    }
                    //if Id not exist 
                } else
                    $response['message'] = "Không tìm thấy User, vui lòng thử lại!";
            }
        } catch (\Throwable $th) {
            $response['message'] = $th;

        }
        return response()->json($response);
    }
}
