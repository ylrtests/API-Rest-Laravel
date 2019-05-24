<?php



Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');


Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('logout', 'AuthController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });

    Route::apiResource('product','ProductController')->except([
        'create', 'edit'
    ]);

    Route::put('product/{product}/activate',[
        'uses' => 'ProductController@activate',
        'as'   => 'product.activate'
        ]);

    Route::get('categorias/select','CategoriaController@select');

});