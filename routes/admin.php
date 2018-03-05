<?php 
Route::group(['prefix'=>'admin','namespace'=>'admin'],function(){
    Config::set('auth.defaults','admin'); // make guard make admin default
    Route::get('login','AdminAuth@login');
    Route::get('forgot/password','AdminAuth@forgot_password');
    Route::post('forgot/password','AdminAuth@forgot_password_post');
    Route::get('reset/password/{token}','AdminAuth@reset_password');
    Route::post('reset/password/{token}','AdminAuth@reset_password_post');
    Route::post('login','AdminAuth@dologin');
    Route::group(['middleware'=>'admin:admin'],function(){
        Route::resource('admin','AdminController');
        Route::get('/',function(){
            return view('admin.home');
        });
        Route::any('logout','AdminAuth@logout');

        
    });

});
