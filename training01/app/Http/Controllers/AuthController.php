<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;
class AuthController extends Controller
{
    protected $users;
    public function __construct(Users $users){
        $this->users = $users;
    }
    public function Login(){
        return view('auth.login');
    }
    public function Logout()
    {
        Auth::logout();
        return redirect()->route('login'); 
    }
    public function LoginAction(Request $request){
        $messageErrors= [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Password không được để trống',            
        ];
        $credentials = $request->validate([
            'email' => 'required|email',
         'password' => 'required'
        ],$messageErrors);
        $rememberMe = $request->has('remember') ? true : false;        
        $assginIpLogin = $this->AssginIPLoginAction($request->ip(),$request->input('email')); 
        if(Auth::attempt($credentials,$rememberMe)){   
            $user = Auth::user();
            // dd($user);
            $this->AssginIPLoginAction($request->ip(),$request->input('email'));
            // $rememberToken = Str::random(60);
            // $request->session()->put('users', $user);
            // $request->session()->put('remember_token', $rememberToken);
            // $user->update(['remember_token' => $rememberToken]);           
            return redirect('dashboard');
        }
        return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'Email và Password không chính xác']);
        
    }
    public function Register(){
        return view('auth.register');
    }
    public function RegisterAction(Request $request)
    {
        $messageErrors = [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được đăng ký',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải lớn hơn 5 kí tự',
            'password.regex' => 'Mật khẩu không bảo mật',                
            'repassword.same' => 'Mật khẩu và xác nhận mật khẩu không chính xác',
            'group_role.required' => 'Nhóm không được để trống',
        ];
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:mst_users|email',
            'password' => 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,}$/',
            'repassword' => 'same:password',
            'group_role' => 'required',
        ], $messageErrors);
        $user = [
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'group_role' => $request->input('group_role'),
            'is_active' => 1,
            'is_delete' => 0,
        ];
        $newUser = $this->users->query()->create($user);
        if ($newUser) {
            return redirect('login');
        }
    }
    private function AssginIPLoginAction(string $ip = null, string $email)
    {
        if ($ip !== null && $email !== null) {
            $user = $this->users->where('email', $email)->first();
            if ($user) {
                // update last_login_ip,last_login_at
                $user->last_login_ip = $ip;
                $user->last_login_at = NOW();
                $user->save();
                if ($user->last_login_ip === $ip) {
                    return true;
                }
            }
            return false;
        }
    }
}