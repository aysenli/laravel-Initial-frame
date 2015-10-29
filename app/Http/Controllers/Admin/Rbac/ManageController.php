<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Admin\Manage;
use App\Models\Admin\Role;

use App\Http\Requests\Admin\Rbac\CreateManageRequest;
use App\Http\Requests\Admin\Rbac\UpdateManageRequest;

class ManageController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        if($name != '')
            return view('admin.rbac.manage.index')->withPages(Manage::paginate(15));
        else
            return view('admin.rbac.manage.index')->withPages(Manage::where('name' , 'like' , "%{$name}%")->paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rbac.manage.create')->with('roleRows',Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateManageRequest $request , Manage $manageModel)
    {
        $inputs = $request->all();

        $result = $manageModel->submitForCreate($inputs);

        $alert = [
            'type'=>'warning',
            'data'=>trans('common.add').trans('rbac.fail'),
            'hrefs'=>[
                ['url'=>route('admin.rbac.manage.index') , 'name'=>trans('rbac.manage').trans('common.list')],
                ['url'=>route('admin.rbac.manage.create' ) , 'name'=>trans('common.add').trans('rbac.manage')]
            ],
            'location'=>[
                'url' => route('admin.rbac.manage.create'),
                'name'=>trans('common.add').trans('rbac.permission')
            ]
        ];

        if($result['status']){
            $alert['type'] = 'success';
            $alert['data']  =   trans('common.add').trans('common.success');
        }else{
            $alert['data']  =   $result['error'];
        }

        return view('admin.common.alert',$alert);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manageRow = Manage::find($id);
        return view('admin.rbac.manage.create')
            ->with('manageRow',$manageRow)
            ->with('roleRows',Role::all())
            ->with('roleCheckeds' , array_fetch($manageRow->roles->toArray() , 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManageRequest $request, Manage $manageModel , $id)
    {
        $inputs = $request->all();

        $alert = [
            'type'=>'warning',
            'data'=>trans('common.add').trans('rbac.fail'),
            'hrefs'=>[
                ['url'=>route('admin.rbac.manage.index') , 'name'=>trans('rbac.manage').trans('common.list')],
                ['url'=>route('admin.rbac.manage.edit' , ['id'=>$id]) , 'name'=>trans('common.edit').trans('rbac.manage')]
            ],
            'location'=>[
                'url' => route('admin.rbac.manage.edit' , ['id'=>$id]),
                'name'=>trans('common.add').trans('rbac.permission')
            ]
        ];

        $result = $manageModel->submitForUpdate($id , $inputs);

        if($result['status']){
            $alert['type'] = 'success';
            $alert['data']  =   trans('common.edit').trans('common.success');
        }else{
            $alert['data']  =   $result['error'];
        }

        return view('admin.common.alert',$alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manage $manageModel , $id)
    {
        $result = $manageModel->submitForDestroy($id);

        if($result['status']){            
            $alert = [
            'type'=>'success',
            'message'=>trans('rbac.manage').trans('common.delete').trans('common.success')   
            ];
        }else{
            $alert = [
            'type'=>'warning',
            'message'=>$result['error']
            ];
        }

        return response()->json($alert);
    }
}
