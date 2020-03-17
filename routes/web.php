<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;


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
    return redirect()->route('dashboard');
});
Route::get('/z',function(){
    $role = Role::firstOrCreate(['name' => 'Branch Accountant']);

    Permission::firstOrCreate(['name' => 'create client']);
    Permission::firstOrCreate(['name' => 'view dashboard']);

    $role->givePermissionTo(['view dashboard']);
    $role->givePermissionTo(['create client']);
    // $role->revokePermissionTo(['create client']);

    auth()->user()->assignRole($role);

});


Route::get('/create/role', function(){
    return view('pages.create-role');
});
Route::get('/create/user', function(){
    return view('pages.create-user');
});
Route::get('/settings', function(){
    return view('pages.settings');
});

Route::get('/create/cluster', function(){
    return view('pages.create-cluster');
});

Route::get('/create/fees', function(){
    return view('pages.create-fees');
});
Route::get('/client/list', function(){
    return view('pages.client-list');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::group(['middleware' => ['can:create client']], function () { 
        Route::get('/create/client','ClientController@index')->name('precreate.client');
        Route::post('/create/client','ClientController@create')->name('create.client'); 
    });
    Route::get('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/scopes', function(){
        return auth()->user()->scopesBranch();
    });
    Route::get('/usr/branches','UserController@branches');
});

Route::get('/auth/structure', 'UserController@authStructure')->name('auth.structure');

