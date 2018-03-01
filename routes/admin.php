<?php 
Route::group(['prefix'=>'admin','namespace'=>'admin'],function(){
    Config::set('auth.defines','admin'); // make guard make admin default
    Route::get('login','AdminAuth@login');
    Route::post('login','AdminAuth@dologin');
    Route::group(['middleware'=>'admin:admin'],function(){

        Route::get('/',function(){
            return view('admin.home');
        });
        Route::any('logout','AdminAuth@logout');

        
    });

});
