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

Route::get('/admin', function () {
    if (Auth::check()) {
        // The user is logged in...
        return redirect('/admin/configurations');
    }
    return view('auth.login');
});
Route::group(['middleware' => []], function () {
    Route::get('/', function () {
        return redirect('/admin');
    });
    Route::get('login', function () {
        return redirect('/admin');
    });
    Route::get('/login', function () {
        return redirect('/admin');
    });

    Auth::routes();

    Route::get('/logout', 'Auth\LoginController@logout');
});

Route::group(['middleware' => ['auth_admin'], 'prefix' => 'admin'], function () {
    
    Route::any('configurations', [
        'as'   => 'admin.configurations.manage',
        'uses' => 'Admin\ConfigurationsController@manage'
    ]);
});

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
Route::get('/home', 'HomeController@index')->name('home');
