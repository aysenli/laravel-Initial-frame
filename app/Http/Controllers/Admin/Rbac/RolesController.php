<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Models\Admin\Navigation;
use Session;

use App\Http\Requests\Admin\Rbac\CreateRolesRequest;
use App\Http\Requests\Admin\Rbac\UpdateRolesRequest;

class RolesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('admin.rbac.index')->withPages(Role::all()); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permission , Navigation $navigation)
    {         
        return view('admin.rbac.create')->with('navigationRows' , $navigation->getAllNavigationForChildren())
                ->with('permissionRows' , $permission->getAllPermissionForChildren());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolesRequest $rolesRequest)
    {
        $inputs = $rolesRequest->all();
        $roleModel = new Role();
        $result = $roleModel->submitForCreate($inputs);
        $alert = [];
        $location = ['href'=>route('admin.rbac.roles.index'),'name'=>trans('rbac.role').trans('common.list')];
        if($result['status']){
            $alert = [
            'type'=>'success',
            'data'=>[trans('rbac.add_roles').trans('common.success')],
            'location'=>$location
            ];
        }else{
            $alert = [
            'type'=>'warning',
            'data'=>[$result['error']],
            'location'=>$location
            ];
        }
        // return new JsonResponse($alert);
        return view('admin.common.alert').with($alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
