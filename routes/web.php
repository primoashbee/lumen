<?php

use App\Client;
use App\Office;
use App\Deposit;
use Carbon\Carbon;
use App\DepositAccount;
use App\Events\TestEvent;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
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

Route::get('/dp',function(){
    $parent_level = "branch";
    $level = "";
    $list = Office::schema()->filter(function($item) use ($parent_level){
        if ($item['level']==$parent_level) {
            return ($item['children']);
        }
    })->values()->first()['children'];

    return in_array($level,$list) ? 'yup' :'wala';
});
Route::get('/x/{level}',function(Request $request){
        return auth()->user()->scopesBranch(Office::getParentOfLevel($request->level));
    });

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

Route::get('/create/office/{level}', 'OfficeController@createLevel')->name('create.office');


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
    
    Route::post('/create/office/', 'OfficeController@createOffice');

    Route::get('/office/{level}', 'OfficeController@viewOffice');
    Route::get('/office/list/{level}','OfficeController@getOfficeList');

    Route::get('/edit/office/{id}', 'OfficeController@editOffice');
    Route::post('/edit/office/{id}', 'OfficeController@updateOffice');

    Route::get('client/{client_id}/deposit/{deposit_account_id}', 'ClientController@depositAccount')->name('client.deposit'); 

    Route::post('/deposit/{deposit_account_id}','DepositAccountController@deposit')->name('client.make.deposit');
    Route::get('/payment/methods','PaymentMethodController@fetchPaymentMethods');

});

Route::get('/auth/structure', 'UserController@authStructure')->name('auth.structure');

