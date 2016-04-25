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

Route::get('/profile/{account}', [
    'as' => 'profile', 'uses' => 'ProfileController@getProfile'
]);

Route::get('/leaderboard/{season}', [
    'as' => 'leaderboard.index', 'uses' => 'LeaderboardController@getLeaderboardRedirect'
]);

Route::get('/leaderboard/{season}/{playlist}', [
    'as' => 'leaderboard', 'uses' => 'LeaderboardController@getLeaderboard'
]);

Route::get('/about', ['as' => 'about', 'uses' => 'HomeController@getAbout']);
Route::get('/', ['as' => 'index', 'uses' => 'HomeController@getIndex']);