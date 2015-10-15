<?php

namespace App\Http\Controllers\Admin;

use Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;

class AdminController extends Controller
{
   public function __construct()
   {
        //面包屑
        $this->userIndex();
   }

   private function userIndex()
   {
        $permission = new Permission();
        view()->share('userIndex' , $permission->whereName('admin.rbac.roles.store')->pluck('display_name'));
   }

}
