<?php
namespace App\Http\Controllers\JWT;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtController extends Controller
{
    public function __construct(){
        $this->middleware('third.auth',['except' => ['doRegister','doLogin']]);
    }
    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required|string|max:255',
            'email' =>  'required|string|email|max:255|unique:users',
            'password'  =>  'required|string|min:6'
        ],[
            'name.required' =>  '姓名为必传项',
            'name.string'   =>  '姓名必须为字符串',
            'name.max'      =>  '姓名最大长度为255',
            'email.required'=>  '邮箱为必传项',
            'email.string'  =>  '邮箱必须为字符串',
            'email.email'   =>  '邮箱格式不正确',
            'email.max'     =>  '邮箱最大长度为255',
            'email.unique'  =>  '邮箱已存在',
            'password.required' =>  '密码为必传项',
            'password.string'   =>  '密码必须为字符串',
            'password.min'      =>  '密码最小长度为6',
        ]);

        if($validator->fails()){
            return $this->response([], $validator->errors()->first(), 500);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return $this->response(["token" => $token],'注册成功');
    }

    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' =>  'required|string|email|max:255|exists:users,email',
            'password'  =>  'required|string|min:6'
        ],[
            'email.required'=>  '邮箱为必传项',
            'email.string'  =>  '邮箱必须为字符串',
            'email.email'   =>  '邮箱格式不正确',
            'email.max'     =>  '邮箱最大长度为255',
            'email.exists'   =>  '无权登录请先注册',
            'password.required' =>  '密码为必传项',
            'password.string'   =>  '密码必须为字符串',
            'password.min'      =>  '密码最小长度为6',
        ]);

        if($validator->fails()){
            return $this->response([], $validator->errors()->first(), 500);
        }
        $credentials = $request->only('email', 'password');
        try {

            if(!$token = JWTAuth::attempt($credentials)){
                return $this->response([], '未登录成功', 401);
            }
        } catch (JWTException $e) {
            return $this->response([], $e->getMessage(), 401);
        }

        $user = User::query()->where('email',$request->input('email'))->first();

        return $this->response(["user" => $user,"token" => $token],'登录成功');
    }

    public function getUserInfo(Request $request)
    {
        $user = JWTAuth::parseToken()->touser();
        return $this->response(["user" => $user],'登录成功');
    }

    public function doLogout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();
        } catch (JWTException $e) {
            return $this->response([],'退出失败',500);
        }

        return $this->response([],'退出成功');
    }

}
