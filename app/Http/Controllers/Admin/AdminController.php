<?php

namespace App\Http\Controllers\Admin;

use Route;
use Session;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;


class AdminController extends Controller
{
   public function __construct()
   {    
      //如果session有存在errors
      if($erros = Session::get('errors')){
        view()->share('errors' , $erros->toArray());
      }else{
        //获取面包屑
        $this->userIndex();
      }
      
   }

   /**
    * 当前面包屑
    * @return [type] [description]
    */
   private function userIndex()
   {
        $permission = new Permission();
        $current = Route::currentRouteName();
        $name = '';
        if ($permissionRows = Cache::has('permissionRows')){
            $permissionRow = Cache::get('permissionRows');
            $name = (isset($permissionRow[$current]) && isset($permissionRow[$current]['display_name'])) ? $permissionRow[$current]['display_name'] : '';
        }
        if($name == ''){
          $name = $permission->whereName($current)->pluck('display_name');
        }
        view()->share('userIndex' , $name);
   }

   
}
