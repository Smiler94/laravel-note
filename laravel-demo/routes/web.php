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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function() {
    return 'hello world';
});

Route::any('/any_method', function () {
    return 'hello,world';
});

Route::match(['get','post'], '/match_method', function() {
    return 'method is '.$_SERVER['REQUEST_METHOD'];
});

Route::get('/welcome', 'WelcomeController@index');

Route::get('/param/direct/{id}', function($id) {
    return 'id is '.$id;
});

Route::get('/param/multi/{id1}/{id2}', function($id3, $id4) {
    return "id1 is {$id3},id2 is {$id4}";
});

Route::get('/param/option/{id?}', function($id = 2) {
    return "id is {$id}";
});

Route::post('/file/upload', 'FileController@upload');

Route::get('/param/preg/{id}', function($id) {
    return "id is {$id}";
})->where('id', '[0-9]+');

Route::get('/param/preg_multi/{id}/{name}', function($id, $name) {
    return "id is {$id},name is {$name}";
})->where([
    'id' => '[0-9]+',
    'name' => '[A-Za-z]+'
]);

Route::group([], function() {
    Route::get('/hello', function() {
        return 'hello';
    });
    Route::get('/world', function() {
        return 'world';
    });
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function() {
        return 'dashboard';
    });
});

Route::get('login', function() {
    return 'login';
})->name('login');

Route::group(['prefix' => 'prefix'], function() {
    Route::get('/', function() {
        return 'prefix root';
    });

    Route::get('/api', function() {
        return 'prefix api';
    });
});

Route::resource('task', 'TaskController');
Route::resource('recipe', 'RecipeController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
