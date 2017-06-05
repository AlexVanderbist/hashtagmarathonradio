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

Route::get('/live', function () {
    return redirect('/');
});

Route::get('/countdown', function () {
    if (\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse(config('hmr.start_time')))) {
        return redirect('/');
    }

    return view('countdown');
});

Route::get('/debug', function () {
    dump(new \App\Events\DashboardUpdate());
});

Route::get('/', 'DashboardController@index');
