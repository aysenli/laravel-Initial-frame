<?php

namespace App\Models\Admin;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Config;

class Manage extends  Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'manages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @author luffyzhao
     * @todo 因为改了用户表和用户主键字段所以要重写 EntrustUserTrait::roles 方法
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), 'manage_id', 'role_id');
    }

    public function getRoles()
    {
        $rolesRows = $this->roles()->where('manage_id' , 1)->get();
        $roles = [];
        if($rolesRows){
            foreach ($rolesRows as $key => $value) {
               $roles[$key] = ($value->id); 
            }  
        }
        return $roles;
    }
}
