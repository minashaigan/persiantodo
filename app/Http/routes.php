<?php



// Home Page
Route::get('/home', 'AuthController@home');
Route::get('/', 'AuthController@home');

// Login and Logout
Route::get('/login', ['middleware' => 'guest', 'uses' => 'AuthController@getLogin']);
Route::post('/login', ['middleware' => 'guest', 'uses' => 'AuthController@postLogin']);
Route::get('/logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);

// Registration and User Profile
Route::resource('user', 'UserController', ['except' => ['index', 'show', 'destroy']]);

// List Resources
Route::resource('list', 'ListController', ['middleware' => 'auth']);
Route::get('list/edit/{id}','ListController@edit');
Route::get('list/edited/{id}','ListController@edited');

//To do Resources
Route::resource('todo', 'TodoController', ['middleware' => 'auth']);
Route::get('todo/create/{id}', 'TodoController@create');
Route::get('todo/list/{id}','TodoController@show');
Route::get('todo/info/{id}','TodoController@info');
Route::get('todo/edit/{id}','TodoController@edit');
Route::get('todo/submit_edit/{id}', [
    'as' => 'edit',
    'uses' => 'TodoController@submit_edit'
]);
Route::get('todo/filter/{id}/{list_id}','TodoController@filter');
Route::get('todo/{id}','TodoController@index');
Route::get('todo/notify/{id}','TodoController@notify');
