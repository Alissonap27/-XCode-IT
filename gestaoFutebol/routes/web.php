<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/jogador', 'PlayerController@created');

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => '/'], function () {
    Route::group(['prefix' => 'jogador'], function () {
        Route::get('', ['as' => 'player.index', 'uses' => 'PlayerController@index']);
        Route::get('criar', ['as' => 'player.created', 'uses' => 'PlayerController@created']);
        Route::post('salva', ['as' => 'player.store', 'uses' => 'PlayerController@store']);

    });

    Route::group(['prefix' => 'time'], function () {
        Route::get('', ['as' => 'team.index', 'uses' => 'TeamController@index']);
        Route::get('criar', ['as' => 'team.created', 'uses' => 'TeamController@created']);
        Route::post('salva', ['as' => 'team.store', 'uses' => 'TeamController@store']);
    });

    Route::group(['prefix' => 'partida'], function () {
        Route::get('', ['as' => 'match.index', 'uses' => 'MatchController@index']);
        Route::get('criar', ['as' => 'match.created', 'uses' => 'MatchController@created']);
        Route::post('salva', ['as' => 'match.store', 'uses' => 'MatchController@store']);
    });
});

