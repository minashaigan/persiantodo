<?php

// Home Page
Route::get('/', 'AuthController@home');

// Login and Logout
Route::get('/login', ['middleware' => 'guest', 'uses' => 'AuthController@getLogin']);
Route::post('/login', ['middleware' => 'guest', 'uses' => 'AuthController@postLogin']);
Route::get('/logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);

// Registration and User Profile
Route::resource('user', 'UserController', ['except' => ['index', 'show', 'destroy']]);

// List Resources
Route::resource('list', 'ListController', ['middleware' => 'auth']);

//To do Resources

Route::resource('todo', 'TodoController', ['middleware' => 'auth']);
Route::get('todo/create/{id}', 'TodoController@create');
Route::get('todo/list/{id}','TodoController@show');
Route::get('todo/{id}','TodoController@index');
