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
    return redirect('/countdown');
});

Route::get('/countdown', function () {
    return view('countdown');
});

Route::get('/debug', function () {
    \DebugBar::enable();

    dump(new \App\Events\DashboardUpdate());
});

Route::get('/beta', 'DashboardController@index');
