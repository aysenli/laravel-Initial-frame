<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Common\LoginRequest;

class LoginController extends Controller
{
    public function __construct(Guard $guard)
    {
        if (!$guard->guest()) {
            return redirect()->guest('admin/index');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin.common.login');
    }

    public function postIndex(Guard $guard , LoginRequest $loginRequest)
    {
        $data = [
            'status' => 0,
            'message'=> '',
        ];
        $inputs = $loginRequest->all();
        $credentials = ['name'=>$inputs['name'] , 'password'=>$inputs['password']];
        if ($guard->attempt($credentials, false))
        {
            $data['status'] = 1;
            $data['message'] = trans('auth.login_success');
        }else{
            $data['message'] = trans('auth.login_not_success');
        }
        return new JsonResponse($data);
    }

    public function getLogout(Guard $guard)
    {
        $guard->logout();
        return redirect('/admin');
    }

    public function getText(){
        $admin = new \App\Models\Admin\Role();
        $admin->id = 1;       
        $editUser = new \App\Models\Admin\Permission();
        $editUser->id         = 1;       
        // $admin->attachPermission($editUser);
        // 
        $manage = new \App\Models\Admin\Manage();
        // $manage->name = "admin";
        // $manage->email = 'luffzhao@vip.163.com';
        // $manage->password = bcrypt('123456');
        // $manage->save();
        $manage->id = 1;
        // $manage->attachRole($admin);
        // or
        $manage->roles()->attach($admin->id);

    }
  
}
