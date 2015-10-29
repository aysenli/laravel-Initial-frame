<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Admin\Permission;

use App\Http\Requests\Admin\Rbac\CreatePermissionRequest;
use App\Http\Requests\Admin\Rbac\UpdatePermissionRequest;
use Session;
class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $permissionModel)
    {
        return view('admin.rbac.permission.index')->with('permissionRows' , $permissionModel->getAllPermissionForChildren());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permissionModel)
    {
        // print_r(Session::all());
        return view('admin.rbac.permission.create')
            ->with('permissionRows' , $permissionModel->where('pid',0)->get()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Permission $permissionModel , CreatePermissionRequest $permissionRequest)
    {

        $inputs = $permissionRequest->all();

        $permissionID = $permissionModel->insertGetId([
            'name'=>$inputs['name'] , 
            'display_name'=>$inputs['display_name'] , 
            'description'=>$inputs['description']
        ]);

        if($permissionID){
            $hrefs = [
                ['url'=>route('admin.rbac.permission.index') , 'name'=>trans('rbac.permission').trans('common.list')], 
                ['url'=>route('admin.rbac.permission.edit' , ['id'=>$permissionID]) , 'name'=>trans('common.edit').trans('rbac.permission')]
            ];
            $alert = [
                'type'=>'success',
                'hrefs'=>$hrefs,
                'location' => ['url'=>route('admin.rbac.permission.edit' , ['id'=>$permissionID]) ,'name'=>trans('common.edit').trans('rbac.permission')],
                'data'  =>  trans('common.add').trans('rbac.permission').trans('common.success')
            ];
        }else{
            $alert =  [
                'type'=>'warning',
                'data'=>trans('common.add').trans('rbac.permission').trans('common.fail'),
                'location'=>['url'=>route('admin.rbac.permission.create') , 'name'=>trans('common.add').trans('rbac.permission')]
            ];
        }
        return view('admin.common.alert',$alert);
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permissionModel, $id)
    {
        $permissionRow = $permissionModel->find($id)->toArray();
        if(!$permissionRow){
            return view('admin.common.alert' , [
                'type'=>'warning',
                'data'=>trans('rbac.permission_not_exist'),
                'location'=>['url'=>route('admin.rbac.permission.index') , 'name'=>trans('rbac.permission').trans('common.list')]
            ]);
        }
        // print_r($permissionRow);die();
        return view('admin.rbac.permission.create')->with('permissionRow' , $permissionRow)
                ->with('permissionRows' , $permissionModel->where('pid',0)->get()->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $permissionRequest , Permission $permissionModel , $id)
    {
        $inputs = $permissionRequest->all();

        $alert = [
            'type'=>'warning',
            'data'=>trans('common.edit').trans('rbac.fail'),
            'hrefs'=>[
                ['url'=>route('admin.rbac.permission.index') , 'name'=>trans('rbac.permission').trans('common.list')],
                ['url'=>route('admin.rbac.permission.edit' , ['id'=>$id]) , 'name'=>trans('common.edit').trans('rbac.permission')]
            ],
            'location'=>[
                'url' => route('admin.rbac.permission.edit' , ['id'=>$id]),
                'name'=>trans('common.edit').trans('rbac.permission')
            ]
        ];

        $isAble = $permissionModel->where('id', '<>', $id)->where('name', $inputs['name'])->count();
        
        if($isAble){
            $alert['data'] = trans('common.unique' , ['name'=>trans('rbac.permission')]);

            return view('admin.common.alert',$alert);
        }
     
        $result  = $permissionModel->where('id', $id)->update([
            'name'=>$inputs['name'],
            'display_name' => $inputs['display_name'],
            'description' => $inputs['description']
        ]);

        if(!$result){
            $alert['data'] = trans('common.unique' , ['name'=>trans('rbac.permission')]);
            // return view('admin.common.alert', $alert);
        }else{
            $alert['data'] = trans('common.edit').trans('common.success');
            $alert['type'] = 'success';   
        }
        

        return view('admin.common.alert' , $alert);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permissionModel , $id)
    {
        $result = $permissionModel->find($id)->delete();

        $alert = [
            'type'=>'warning',
            'message'=>trans('common.delete').trans('common.fail')
        ];

        if($result){            
           $alert['type'] = 'success';
           $alert['message'] = trans('common.delete').trans('common.success');
        }

        return response()->json($alert);
    }
}
