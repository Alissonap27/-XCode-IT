<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('jogadores-time/{id}', ['as' => 'players.team', 'uses' => 'PlayerController@findPlayersByTeam']);

Route::get('teams/', 'TeamController@all');
Route::get('matchs/', 'MatchController@all');
Route::get('players/', 'PlayerController@all');
