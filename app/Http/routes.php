<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/





//后台
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{  	
	// Route::get('/' , 'IndexController@index');
	Route::get('/' , ['as'=>'login_user','uses'=>'IndexController@index']);
	Route::get('/index/main' , ['as'=>'login_user','uses'=>'IndexController@main']);
	//
	#权限管理
	Route::group(['prefix'=>'rbac' , 'namespace'=>'Rbac' ,  'middleware'=>'authLogin'] , function(){
		Route::resource('roles' , 'RolesController');
	});
	#公共
	Route::group(['prefix'=>'common' , 'namespace'=>'Common'] , function(){
		// Route::resource('index' , 'IndexController');
		
		Route::controller('login' , 'LoginController');

		Route::controller('left' , 'LeftController');
		

		//验证码·
		Route::get('captcha/{type}' , function($type='default')
		{
			return Captcha::create($type);
		});
	});	
	
});


// Route::filter('manage_posts', function()
// {
// 	if (!Entrust::can('create_post')) {				
// 	}	
// });	
// Route::when('admin/auth/islogin', 'manage_islogin');


