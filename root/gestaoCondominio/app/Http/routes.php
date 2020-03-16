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

Route::get('/', ['as' => 'index', function () {
    return redirect()->route('users.index');
}]);

Route::group(['prefix' => '/'], function () {
    Route::auth();
    Route::group(['prefix' => 'usuarios'], function () {
        Route::match(['GET', 'POST'],'inicio', ['as' => 'users.index', 'uses' => 'UsersController@index']);
        Route::get('{id}/editar', ['as' => 'users.edit', 'uses' => 'UsersController@edit']);
        Route::post('update', ['as' => 'users.update', 'uses' => 'UsersController@update']);        
    });
});