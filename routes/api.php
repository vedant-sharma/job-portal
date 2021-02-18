<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'throttle:60,1'],function(){

Route::group(['middleware' => ['auth']], function() {

	Route::group(['middleware' => ['has_role:candidate']], function() {

		Route::get('/jobs', 'JobController@index');

		Route::get('/jobs/{id}', 'JobController@get');

		Route::post('/jobs/{id}/apply', 'JobController@apply');

		Route::get('/applied-jobs', 'JobController@applied');
	});

	Route::group(['middleware' => ['has_role:recruiter']], function() {

		Route::post('/jobs/new', 'JobController@create'); 

		Route::get('/posted-jobs', 'JobController@getJobsByRecruiter'); 

		Route::get('/jobs/{id}/applicants','UserController@getUsersByJob'); 

	});
});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/forgot-password', 'AuthController@forgotpassword');
Route::post('/reset-password', 'AuthController@resetPassword');

});







