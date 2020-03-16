@extends('layouts.user')
@section('content')
	<div class="content content pl-32 pr-8 mt-4" id="content-full">
	  <div class="row">
		    <div class="col-md-8">
		      <div class="card">
		        <div class="card-header my-2">
		          <div class="d-block text-center client-image">
		            <img src="{{asset('assets/img/default.png')}}" class="avatar" alt="Profile Photo">
		          </div>
		          <h4 class="px-1 text-center">Client Name</h4>
		        </div>
		        <div class="card-body">
		          <div class="content-wrapper">
		            <div class="row">
		              <div class="form-group col-md-2">
		                <p class="title">Client ID</p>
		                <p class="text-muted">Client ID</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">Nickname</p>
		                <p class="text-muted">Nickname</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">Date Of Birth</p>
		                <p class="text-muted">Date Of Birth</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">Birthplace</p>
		                <p class="text-muted">Birthplace</p>
		              </div>
		              <div class="form-group col-md-4">
		                <p class="title">Marital Status</p>
		                <p class="text-muted">Marital Status</p>
		              </div>
		            </div>
		            <div class="row my-5">
		              <div class="col-md-4">
		                <p class="title">Educational Attainment</p>
		                <p class="text-muted">Educational Attainment</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title">Facebook Account</p>
		                <p class="text-muted">Facebook Account</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title">Phone Number</p>
		                <p class="text-muted">Phone Number</p>
		              </div>
		            </div>
		            <h3 class="my-3">Address Information</h3>
		            <div class="row my-4">
		              <div class="col-md-6">
		                <p class="title">Street Address</p>
		                <p class="text-muted">Street Address</p>
		              </div>
		              <div class="col-md-6">
		                <p class="title">Business Address</p>
		                <p class="text-muted">Business Address</p>
		              </div>
		            </div>
		            <div class="row px-3">
		              <div class="col-md-3 p0">
		                <p class="title">Barangay</p>
		                <p class="text-muted">Barangay</p>
		              </div>
		              <div class="col-md-3">
		                <p class="title">City</p>
		                <p class="text-muted">City</p>
		              </div>
		              <div class="col-md-2">
		                <p class="title">Province</p>
		                <p class="text-muted">Province</p>
		              </div>
		              <div class="col-md-2 col-md-offset-2">
		                <p class="title">Zip code</p>
		                <p class="text-muted">Zip code</p>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-md-4">
		      <div class="card">
		        <div class="card-header">
		          <h4>Loan Accounts
		            <a href="" class="float-right btn-create">Create Account</a>
		          </h4>
		        </div>
		        <div class="card-body">
		          <div class="table-accounts table-full-width table-responsive">
		            <table class="table">
		                
		              <tbody>
		              	<tr>
		                  <td>
		                    <p>Account #</p>
		                  </td>
		                  <td>
		                    <p>Status</p>
		                  </td>
		                </tr>
		                <tr>
		                  <td>
		                    <a href="">
		                      <p class="title">MCBU0001</p>
		                    </a>
		                  </td>
		                  <td>
		                    <span class="active position-relative px-2">
		                      Active
		                    </span>
		                  </td>
		                </tr>
		              </tbody>
		            </table>
		          </div>
		        </div>
		      </div>

		      <div class="card">
		        <div class="card-header">
		          <h4>Deposit Accounts
		            <a href="" class="float-right btn-create">Create Account</a>
		          </h4>

		        </div>
		        <div class="card-body">
		          <div class="table-accounts table-full-width table-responsive">
		            <table class="table">
		              <tbody>
		              	<tr>
		                  <td>
		                    <p>Account #</p>
		                  </td>
		                  <td>
		                    <p>Status</p>
		                  </td>
		                </tr>
		                <tr>
		                  <td>
		                    <a href="">
		                      <p class="title">MCBU0001</p>
		                    </a>
		                  </td>
		                  <td>
		                    <span class="active position-relative px-2">
		                      Active
		                    </span>
		                  </td>
		                </tr>
		              </tbody>
		            </table>
		          </div>
		        </div>
		      </div>
		    </div>
	  	</div>
	</div>
@endsection