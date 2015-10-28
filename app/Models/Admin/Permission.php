<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustPermission;
use DB;

class Permission extends EntrustPermission
{
    /**
     * 获取权限的无限分类
     * @return [type] [description]
     */
	public function getAllPermissionForChildren()
	{
		$allForChildren = [];
		$permissionRows = $this->orderBy('pid' , 'asc')->get()->toArray();

		foreach ($permissionRows as $key => $value) {
			//最上级
			if($value['pid'] == 0){
				$allForChildren[$value['id']]	=	$value;
				// $children = [];
			}else{				
				// $children[$value['id']] = $value;
				$allForChildren[$value['pid']]['children'][$value['id']] = $value;
			}
		}
		return $allForChildren;
	}

	
}
