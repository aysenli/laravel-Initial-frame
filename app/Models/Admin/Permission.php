<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustPermission;
use DB;
use Cache;

class Permission extends EntrustPermission
{
    /**
     * 获取权限的无限分类
     * @return [type] [description]
     */
	public function getAllPermissionForChildren()
	{
		$allForChildren = [];
		$isCache = Cache::has('permissionRows');
		if($isCache){
			$permissionRows = Cache::get('permissionRows');
		}else{
			$permissionRows = $this->orderBy('pid' , 'asc')->get()->toArray();
			$permissionRowsCache = [];
		}	

		foreach ($permissionRows as $key => $value) {
			if($value['pid'] == 0){
				$allForChildren[$value['id']]	=	$value;
			}else{				
				$allForChildren[$value['pid']]['children'][$value['id']] = $value;
			}
			if(!$isCache){
				$permissionRowsCache[$value['name']] = $value;
			}
		}
		if(!$isCache){
			Cache::forever('permissionRows' , $permissionRowsCache);
		}
		return $allForChildren;
	}

	/**
	 * 创建
	 * @param  [type] $inputs [description]
	 * @return [type]         [description]
	 */
	public function submitForCreate($inputs)
	{
		$permissionId = $this->submitForCreate([
            'name'=>$inputs['name'] , 
            'display_name'=>$inputs['display_name'] , 
            'pid'   =>  $inputs['pid'],
            'description'=>$inputs['description']
        ]);

        if($permissionId > 0){
			return ['status'=>true , 'id'=>$permissionId];    
		}
		return ['status'=>false];
	}

	/**
	 * 修改
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function submitForUpdate($id , $inputs)
	{
		$isAble = $this->where('id', '<>', $id)->where('name', $inputs['name'])->count();

		if($isAble > 0){
			return ['status'=>false , 'error'=>trans('common.unique' , ['name'=>trans('rbac.permission')])];
		}

		$permissionRow = $this->find($id);

		if(!$permissionRow){
			return ['status'=>false , 'error'=>trans('auth.id_not_exists')];
		}

		$this->where('id', $id)->update([
            'name'=>$inputs['name'],
            'display_name' => $inputs['display_name'],
            'pid'   =>  $inputs['pid'],
            'description' => $inputs['description']
        ]);

        return ['status'=>true , 'id'=>$id];   
	}

	/**
	 * 删除导航
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function submitForDestroy($id)
	{
		$this->find($id)->delete();

		return ['status'=>true];
	}
}
