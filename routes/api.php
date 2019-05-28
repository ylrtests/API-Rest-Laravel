<?php



Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::post('user', 'AuthController@getUser');



Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('logout', 'AuthController@logout');
    
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });

    Route::apiResource('product','ProductController')->except([
        'create', 'edit', 'destroy'
    ]);

    Route::put('product/update/status/{product}',[
        'uses' => 'ProductController@updateStatusProduct',
        'as'   => 'product.update.status'
        ]);

    Route::get('/categories/select','CategoriaController@select');

});