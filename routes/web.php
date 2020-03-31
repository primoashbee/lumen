<?php

use Carbon\Carbon;
use App\Events\TestEvent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Request;
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

Route::get('/create/fee', function(){
    return view('pages.create-fees');
});

Route::get('/create/penalty', function(){
    return view('pages.create-penalty');
});

Route::get('/create/branch', function(){
    return view('pages.create-branch');
});


Route::get('/settings', function(){
    return view('pages.settings');
})->name('administration');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::group(['middleware' => []], function () { 
        Route::get('/create/client','ClientController@index')->name('precreate.client');
        Route::post('/create/client','ClientController@create')->name('create.client'); 
    });
    Route::get('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/scopes', function(){
        return auth()->user()->scopesBranch();
    });
    Route::get('/usr/branches','UserController@branches');
    Route::get('/clients','ClientController@list')->name('client.list');
    Route::get('/clients/list','ClientController@getList')->name('get.client.list');
    Route::get('/client/{client_id}','ClientController@view')->name('get.client.info');
    Route::get('/edit/client/{client_id}','ClientController@editClient');
    Route::post('/edit/client','ClientController@update');



    Route::get('/event',function(){
        event(new TestEvent('tae ka girl?'));
    
    });
});

Route::get('/auth/structure', 'UserController@authStructure')->name('auth.structure');

