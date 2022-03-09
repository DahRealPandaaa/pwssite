<?php

use Illuminate\Support\Facades\Route;

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
})->name('index');

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');

    Route::prefix('teams')->group(function () {
        Route::get('/', 'App\Http\Controllers\TeamController@index')->name('teams.index');
        Route::get('/create', 'App\Http\Controllers\TeamController@create')->name('teams.create');

        Route::post('/createteam', 'App\Http\Controllers\TeamController@createteam')->name('teams.createteam');
        Route::post('/join', 'App\Http\Controllers\TeamController@join')->name('teams.join');
        Route::post('/leave', 'App\Http\Controllers\TeamController@leave')->name('teams.leave');

    });

    Route::prefix('time')->group(function () {
        Route::get('/', 'App\Http\Controllers\TimeController@index')->name('time.index');
        Route::get('/create', 'App\Http\Controllers\TimeController@create')->name('time.create');
        Route::get('/{id}', 'App\Http\Controllers\TimeController@edit')->name('time.edit');


        Route::post('/update/{id}', 'App\Http\Controllers\TimeController@update')->name('time.editupdate');
        Route::post('/insert', 'App\Http\Controllers\TimeController@insert')->name('time.insert');
    });

    Route::prefix('todo')->group(function () {
        Route::get('/', 'App\Http\Controllers\ToDoController@index')->name('todo.index');

        Route::post('/edit/{id}', 'App\Http\Controllers\ToDoController@edit')->name('todo.edit');
        Route::post('/create/{id}', 'App\Http\Controllers\ToDoController@create')->name('todo.create');

    });
});

require __DIR__.'/auth.php';
