<?php
    

use App\User;
use App\Client;
use App\Office;
use App\Deposit;
use Carbon\Carbon;
use App\LoanAccount;
use App\DepositAccount;
use App\Events\TestEvent;
use App\Exports\CCRExport;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Exports\CollectionSheetExport;
use App\Imports\TestImport;
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

Route::get('/import',function(){
    return view('test');
});
Route::post('/import',function(Request $request){
    Excel::import(new TestImport , $request->file('file'));
    
});

Route::get('/download/ccr',function(Request $request){

    $summary = session('ccr');
    $file = public_path('temp/').$summary->office.' - '.$summary->repayment_date.'.pdf';            
    $pdf = app()->make('dompdf.wrapper');
    $pdf->loadView('exports.test',compact('summary'))->setPaper('a4','landscape');
    return $pdf->stream();
    $pdf->loadView('exports.ccrv2', compact('summary'))->setPaper('a4', 'landscape')->save($file);
    $headers = ['Content-Type'=> 'application/pdf','Content-Disposition'=> 'attachment;','filename'=>$summary->name];
    return response()->download($file,$summary->name,$headers);

});
Route::post('/ccr',function(Request $request){
    $pdf = App::make('dompdf.wrapper');
    $d_ids = array(2,1);
    sort($d_ids);   
    $data = [
        'office_id' => 21,
        'date'=>"2021-02-04",
        'loan_account_id' => 1,
        'deposit_product_ids'=>$d_ids,
    ];
    $d_ids = collect($request->deposit_products)->pluck('id')->sort();
    
    $request->merge([
        'deposit_product_ids' => $d_ids,
        'loan_account_id' => $request->loan_product_id
    ]);
    $request->request->deposit_product_ids = $d_ids;
    $request->request->loan_account_id = $request->loan_product_id;
    $data = $request->all();
    $summary  = \App\Account::repaymentsFromDate($data);
    
    $file = public_path('temp/').$summary->office.' - '.$summary->repayment_date.'.pdf';
    
    $pdf->loadView('exports.ccrv2',compact('summary'))->setPaper('a4','landscape')->save($file);
    // return $pdf->stream();
    
    $headers = ['Content-Type: application/zip','Content-Disposition: attachment; filename={$file}'];

    return response()->download($file, 200,$headers);
});

Route::get('/ccr',function(Request $request){
    $pdf = App::make('dompdf.wrapper');
    $d_ids = array(2,1);
    sort($d_ids);   
    $data = [
        'office_id' => 21,
        'date'=>"2021-02-04",
        'loan_account_id' => 1,
        'deposit_product_ids'=>$d_ids,
    ];
    $d_ids = collect($request->deposit_products)->pluck('id')->sort();
    $summary  = \App\Account::repaymentsFromDate($data);
    
    $file = public_path('temp/').$summary->office.' - '.$summary->repayment_date.'.pdf';
    
    $pdf->loadView('exports.ccrv2',compact('summary'))->setPaper('a4','landscape')->save($file);
    return $pdf->stream();

    $headers = ['Content-Type: application/zip','Content-Disposition: attachment; filename={$file}'];
    return response()->download($file, 200,$headers);
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


Route::get('/loan/products','LoanController@');
Route::get('/random',function(){
    return view('random-picker');
});
Auth::routes();
Route::get('/fees','FeeController@getList');
Route::get('/ssss',function(){
    // \App\LoanAccount::first()->updateStatus();
});
Route::group(['middleware' => ['auth']], function () {

    Route::get('/stepper','ClientController@step');
    Route::get('/pay','RepaymentController@repayLoan');
    Route::post('/loan/calculator', 'LoanAccountController@calculate')->name('loan.calculator');
    Route::post('/products','ProductController@index');

    Route::get('/client/{client_id}/create/dependents', 'ClientController@toCreateDependents')->name('client.create.dependents');
    Route::post('/client/create/dependent', 'DependentController@createDependents')->name('create.dependents.post');
    Route::get('/client/update/dependent', 'DependentController@updateDependentStatus')->name('create.dependents.activate');
    Route::get('/client/{client_id}/manage/dependents', 'ClientController@dependents')->name('client.manage.dependents');
    Route::get('/dependents/{client_id}', 'ClientController@listDependents')->name('client.dependents.list');
    Route::get('/client/{client_id}/create/loan', 'LoanAccountController@index')->name('client.loan.create');
    Route::post('/client/create/loan', 'LoanAccountController@createLoan')->name('client.loan.create.post');
    Route::get('/client/{client_id}/loans', 'LoanAccountController@clientLoanList')->name('client.loan.list');
    Route::get('/loan/approve/{loan_id}','LoanAccountController@approve')->name('loan.approve');
    Route::get('/loan/disburse/{loan_id}','LoanAccountController@disburse')->name('loan.disburse');
    
    Route::get('/client/{client_id}/loans/{loan_id}','LoanAccountController@account')->name('loan.account');
    Route::post('/loans/repay','RepaymentController@accountPayment');
    Route::post('/loans/preterm','RepaymentController@preTerminate');
    Route::post('/revert','RevertController@revert')->name('revert.action');
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::group(['middleware' => []], function () { 
        Route::get('/create/client','ClientController@index')->name('precreate.client');
        Route::post('/create/client','ClientController@createV1')->name('create.client'); 
    });
    Route::get('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/scopes', function(){
        return auth()->user()->scopesBranch();
    });
    Route::get('/usr/branches','UserController@branches');
    Route::get('/clients','ClientController@list')->name('client.list');
    Route::get('/clients/list','ClientController@getList')->name('get.client.list');
    Route::get('/client/{client_id}','ClientController@view')->name('client.profile');
    Route::get('/edit/client/{client_id}','ClientController@editClient');
    Route::post('/edit/client','ClientController@update');
    
    Route::post('/create/office/', 'OfficeController@createOffice');

    Route::get('/office/{level}', 'OfficeController@viewOffice')->name('offices.view');
    Route::get('/office/list/{level}','OfficeController@getOfficeList');

    Route::get('/edit/office/{id}', 'OfficeController@editOffice');
    Route::post('/edit/office/{id}', 'OfficeController@updateOffice');

    Route::get('/client/{client_id}/deposit/{deposit_account_id}', 'ClientController@depositAccount')->name('client.deposit'); 

    Route::post('/deposit/{deposit_account_id}','DepositAccountController@deposit')->name('client.make.deposit'); //make deposit transaction individually
    Route::get('/payment/methods','PaymentMethodController@fetchPaymentMethods');

    
    Route::get('/bulk/deposit', 'DepositAccountController@showBulkView')->name('bulk.deposit.deposit');
    Route::get('/bulk/withdraw', 'DepositAccountController@showBulkView')->name('bulk.deposit.withdraw');
    Route::get('/bulk/post_interest', 'DepositAccountController@showBulkView')->name('bulk.deposit.post_interest');
    
    Route::get('/bulk/create/loans', 'LoanAccountController@bulkCreateForm')->name('bulk.create.loans');
    Route::post('/loans/pending/list', 'LoanAccountController@pendingLoans');
    Route::post('/bulk/create/loans', 'LoanAccountController@bulkCreateLoan')->name('bulk.create.loans.post');
    
    Route::get('/bulk/approve/loans','LoanAccountController@bulkApproveForm')->name('bulk.approve.loans');
    Route::post('/bulk/approve/loans','LoanAccountController@bulkApprove')->name('bulk.approve.loans.post');
    
    Route::post('/loans/approved/list','LoanAccountController@approvedLoans');
    Route::get('/bulk/disburse/loans','LoanAccountController@bulkDisburseForm')->name('bulk.disburse.loans');
    Route::post('/bulk/disburse/loans','LoanAccountController@bulkDisburse')->name('bulk.disburse.loans.post');
    
    Route::post('/bulk/deposit', 'DepositAccountController@bulkDeposit')->name('bulk.deposit.deposit.post');
    Route::post('/bulk/withdraw', 'DepositAccountController@bulkWithdraw')->name('bulk.deposit.withdraw.post');
    Route::post('/bulk/post_interest', 'DepositAccountController@bulkPostInterest')->name('bulk.deposit.interst_post.post');
    
    Route::get('/bulk/repayment','RepaymentController@showBulkForm')->name('bulk.repayment');
    Route::post('/bulk/repayments','RepaymentController@bulkRepayment')->name('bulk.repayment.post');
    Route::post('/loans/scheduled/list','RepaymentController@scheduledList');
    
    
    Route::get('/deposits','DepositAccountController@showList');
    Route::get('/product','ProductController@getItems');
    Route::post('/deposit/{deposit_account_id}','DepositAccountController@deposit')->name('client.make.deposit');
    Route::post('/deposit/account/post/interest','DepositAccountController@postInterestByUser')->name('deposit.account.post.interest');


    Route::get('/accounts/{type}','AccountController@index')->name('accounts.list');

    // Route::post('/accounts/{type}','AccountController@filter')->name('accounts.all');

    Route::post('/loans/list','LoanController@postInterestByUser')->name('deposit.account.post.interest');


    Route::get('/loan/products','LoanController@loanProducts')->name('loan.products');
    Route::get('/settings/loan','LoanController@index')->name('settings.loan-products');
    Route::get('/settings/api/get/loans','LoanController@loanProducts')->name('settings.loan-list');
    Route::get('/auth/structure', 'UserController@authStructure')->name('auth.structure');


    Route::get('/settings/create/role', function(){
        return view('pages.create-role');
    });
    Route::get('/settings/create/user', function(){
        return view('pages.create-user');
    })->name('create.user');

    Route::get('/settings/create/fee', function(){
        return view('pages.create-fees');
    });

    Route::get('/settings/create/penalty', function(){
        return view('pages.create-penalty');
    });

    Route::get('/settings/create/office/{level}', 'OfficeController@createLevel')->name('create.office');

    Route::post('/search','SearchController@search');

    Route::get('/settings', function(){
        return view('pages.settings');
    })->name('administration');

    Route::get('/user/{user}','UserController@get');
    Route::get('/settings/create/loan', function(){
        return view('pages.create-loan');
    });

    Route::get('/settings/loan/edit/{loan}','LoanController@updateLoan'); //render view
    Route::get('/settings/loan/product/edit/{id}','LoanController@loanProduct'); //get product via id

    Route::post('/settings/loan/edit/{id}','LoanController@updateLoanProduct'); //post view
    
    Route::get('/settings/loan/view/{loan}','LoanController@viewLoan');
    
    Route::post('/settings/create/loan','LoanController@create');
    
    });
 

