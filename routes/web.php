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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([ 'prefix' => 'tasks' ], function ($router) {
    Route::get('/index', 'TaskController@index')->name('tasks.index');
    Route::post('/store', 'TaskController@store')->name('tasks.store');
    Route::put('/update/{taskId}', 'TaskController@update')->name('tasks.update');
    Route::delete('/delete/{taskId}', 'TaskController@destory')->name('tasks.destory');
    Route::put('/mark/{taskId}/done', 'TaskController@markTaskDone')->name('tasks.markDone');
    Route::put('/mark/{taskId}/undone', 'TaskController@markTaskUndone')->name('tasks.markUndone');
});
