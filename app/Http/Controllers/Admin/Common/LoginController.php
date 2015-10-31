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
            'type' => 'warning',
            'message'=> '',
        ];
        $inputs = $loginRequest->all();
        $credentials = ['name'=>$inputs['name'] , 'password'=>$inputs['password']];
        if ($guard->attempt($credentials, false))
        {
            $data['type'] = 'success';
            $data['message'] = trans('auth.login_success');
        }else{
            $data['message'] = trans('auth.login_not_success');
        }
        return  response()->json($data);
    }

    public function getLogout(Guard $guard)
    {
        $guard->logout();
        return redirect('/admin');
    }
    
  
}
