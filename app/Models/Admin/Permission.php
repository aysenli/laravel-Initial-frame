<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * 获取权限的无限分类
     * @return [type] [description]
     */
	public function getAllPermissionForChildren()
	{
		$allForChildren = array();
		$permissionRows = $this->select('id','name','pid','display_name')->orderBy('pid' , 'asc')->get();

		foreach ($permissionRows as $key => $value) {
			//最上级
			if($value['pid'] == 0){
				$allForChildren[$value['id']]	=	$value;
			}else{
				$children[$value['id']] = $value;
				$allForChildren[$value['pid']]->children = $children;
			}
		}
		return $allForChildren;
	}
}
