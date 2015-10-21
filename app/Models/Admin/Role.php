<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustRole;

use DB;
// use PermissionRole;

class Role extends EntrustRole
{
    /**
     * 视图创建角色
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function submitForCreate($inputs)
    {

    	DB::beginTransaction();    	
    	try {
    		$roleID = $this->insertGetId([
    			'name'=>$inputs['name'] , 
    			'display_name'=>$inputs['display_name'] , 
    			'description'=>$inputs['description']
			]);
    		if(!$roleID){
    			throw new Exception("Error Processing Request", 1);    			
    		}
    		if(isset($inputs['permission_id']) && !empty($inputs['permission_id'])){    			
    			$permissionRoleInsertArray = array();
    			foreach ($inputs['permission_id'] as $key => $value) {
    				$permissionRoleInsertArray[$key] = ['permission_id'=>$value , 'role_id'=>$roleID];
    			}
    			$permissionRoleModel = new PermissionRole();
    			if(!$permissionRoleModel->insert($permissionRoleInsertArray)){
    				throw new Exception("Error Processing Request", 1);    				
    			}
    		}

    		if(isset($inputs['navigation_id']) && !empty($inputs['navigation_id'])){ 
    			$rolesNavigationInsertArray	=	array();
    			foreach ($inputs['navigation_id'] as $key => $value) {
    				$rolesNavigationInsertArray[$key] = ['role_id'=>$roleID , 'navigation_id'=>$value];
    			}
    			$rolesNavigationModel = new RoleNavigation();
    			if(!$rolesNavigationModel->insert($rolesNavigationInsertArray)){
    				throw new Exception("Error Processing Request", 1);   
    			}
    		}
    		DB::commit();
			return ['status'=>true];    		
    	} catch (Exception $e) {
    		DB::rollback();
    		return [
    			'status'=>false,
    			'error'=>trans('rbac.add_roles').trans('rbac.fail')
    		];
    	}
    }
    
}
