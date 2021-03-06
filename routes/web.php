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

//Route::get('/', function () {
//    return view('home');
//});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/players', 'PlayerController@show')->name('players_lists');

Route::get('/evaluation/form', 'EvaluationController@index')->name('evaluation_form');

Route::get('/match/review/{id}', 'MatchReviewController@index')->name('match_review');

Route::get('/user/match/review/{id}', 'UserReviewController@index')->name('user_review');

Route::get('/users/{id}', 'UserController@index')->name('user_show');

Route::get('/teams/{id}', 'TeamController@index')->name('team_show');

Route::get('/user/edit/{id}', 'UserController@edit_index')->name('user_edit_show');

Route::get('/contact', 'ContactController@input')->name('contact');

Route::get('/vote', 'VoteController@index')->name('vote');

//Route::get('/blog/lists', 'BlogController@index')->name('blog_lists');

//Route::group(['middleware' => 'admin_auth'], function(){
//
//    Route::get('/blog/form', 'BlogController@show_form')->name('blog_form');
//
//});

Route::get('/schedule',
    function () { return view('schedule');
});

Route::post('/create/team', 'TeamController@create')->name('create');

Route::post('/create/player', 'PlayerController@create')->name('player_create');

Route::post('/create/mvp', 'EvaluationController@create')->name('evaluation_create');

Route::post('/create/comment', 'UserReviewController@comment_create')->name('comment_create');

Route::post('/user/update/{id}', 'UserController@update')->name('user_update');

Route::post('/contact/send', 'ContactController@send')->name('contact_send');

Route::post('/delete', 'EvaluationController@delete')->name('delete');

Route::post('/vote_/create', 'VoteController@create')->name('vote_create');

//Route::post('/create/blog', 'BlogController@create')->name('blog_create');








