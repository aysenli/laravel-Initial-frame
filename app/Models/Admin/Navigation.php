<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;


class Navigation extends Model
{
	protected $table = 'navigation';

	public function roles()
	{
		return $this->belongsToMany('App\Models\Admin\Role' , 'roles_navigation');
	}
	/**
	 * 获取用户菜单
	 * @author luffyzhao
	 * @param Object $user 登陆用户
	 * @param Integer $navigationPid 
	 * @param Integer $level 
	 * @return Array     
	 */   
    public function getUserNavigationForId($user , $navigationPid = 0 , $level = 1)
    {
    	$navigationData	=	array();

    	$navigationRows	=	$this->where('pid',$navigationPid)->orderBy('id','sort')->get();
    	
    	if($navigationRows){    	
    		// 检查权限    		
	    	foreach ($navigationRows as $key => $value) {
	    		foreach($value->roles()->get() AS $roles){
	    			if($user->hasRole($roles->name)){
	    				if(($level - 1) > 0){
			    			$value->children = $this->getUserNavigationForId($user , $value->id , $level - 1 );
			    		}
			    		$navigationData[$key] = $value;
	    				break;
	    			}
	    		}
	    			    				
	    	}
	    }

    	return $navigationData;
    }

    /**
     * 获取导航的无限分类
     * @return [type] [description]
     */
    public function getAllNavigationForChildren($pid = 0)
	{
		$allForChildren = array();
		$navigationRows = $this->select('id','name','pid')->orderBy('pid' , 'asc')->where('pid',$pid)->get();
		if($navigationRows){
			foreach ($navigationRows as $key => $value) {		
				$value->children = $this->getAllNavigationForChildren($value['id']);
				$allForChildren[$value['id']]	=	$value;	
			}	
		}			

		return $allForChildren;
	}

}
