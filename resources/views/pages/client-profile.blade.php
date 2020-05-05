@extends('layouts.user')
@section('content')

	<div class="content content pl-32 pr-8 mt-4" id="content-full">

	  <div class="row">
		    <div class="col-md-8"> 	
		      <div class="card pb-4">
		      	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="/clients">Client List</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Profile</li>
				  </ol>
				</nav>
		        <div class="card-header my-2">
		          <div class="d-block text-center client-image">
		            <img src="{{asset($client->profile_picture_path)}}" class="avatar" alt="Profile Photo">
		          </div>
				  <h4 class="px-1 text-center text-lg">{{$client->name()}}</h4>
		        </div>
		        <div class="card-body">
		          <div class="content-wrapper profile-information">
		          	<h3 class="my-3 text-xl">Personal Details</h3>
		            <div class="row">
		              <div class="form-group col-md-2">
		                <p class="title text-lg">{{$client->client_id}}</p>
		                <p class="text-muted text-lg">Client ID</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title text-lg">{{$client->nickname}}</p>
		                <p class="text-muted text-lg">Nickname</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title text-lg">{{$client->birthday}}</p>
		                <p class="text-muted text-lg">Date Of Birth</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title text-lg">{{$client->birthplace}}</p>
		                <p class="text-muted text-lg">Birthplace</p>
		              </div>
		              <div class="form-group col-md-4">
		                <p class="title text-lg"> {{$client->civil_status}}</p>
		                <p class="text-muted text-lg">Marital Status</p>
		              </div>
		            </div>
		            <div class="row my-5">
		              <div class="col-md-4">
		                <p class="title text-lg">{{$client->education}}</p>
		                <p class="text-muted text-lg">Educational Attainment</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title text-lg">{{$client->fb_account}}</p>
		                <p class="text-muted text-lg">Facebook Account</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title text-lg">{{$client->contact_number}}</p>
		                <p class="text-muted text-lg">Phone Number</p>
		              </div>
		            </div>
		            <h3 class="my-3 text-xl">Address Information</h3>
		            <div class="row my-4">
		              <div class="col-md-6">
		                <p class="title text-lg">{{$client->street_address}}</p>
		                <p class="text-muted text-lg">Residential Street Address</p>
		              </div>
		              <div class="col-md-6">
		                <p class="title text-lg">{{$client->business_address}}</p>
		                <p class="text-muted text-lg">Business Address</p>
		              </div>
		            </div>
		            <div class="row px-3">
		              <div class="col-md-3 p0">
		                <p class="title text-lg">{{$client->barangay_address}}</p>
		                <p class="text-muted text-lg">Barangay</p>
		              </div>
		              <div class="col-md-3">
		                <p class="title text-lg">{{$client->city_address}}</p>
		                <p class="text-muted text-lg">City</p>
		              </div>
		              <div class="col-md-2">
		                <p class="title text-lg">{{$client->province_address}}</p>
		                <p class="text-muted text-lg">Province</p>
		              </div>
		              <div class="col-md-2 col-md-offset-2">
		                <p class="title text-lg">{{$client->zipcode}}</p>
		                <p class="text-muted text-lg">Zip code</p>
		              </div>
		            </div>
		          </div>
		          <div class="col-lg-10 mt-4 p0">
		          	<a href="/edit/client/{{$client->client_id}}" type="submit" class="btn btn-primary mt-8 px-8">Edit Client</a>
		          	<div  class="file-input-signature float-right">
		                <img src="https://cdn.sstatic.net/Img/unified/sprites.svg?v=e5e58ae7df45" class="img-thumbnail" alt="Cinque Terre" > 
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-md-4">
		      <div class="card">
		        <div class="card-header">
		          <div class="float-left text-center">
		          	<i class="fas fa-3x fa-hand-holding-usd t-white"></i>
		          	<h4 class="mt-2">Loan Accounts</h4>
		          </div>
		           <a href="" class="float-right btn-create">Create Account</a>
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
			          <div class="float-left text-center">
			          	<i class="fas fa-3x fa-donate t-white"></i>
			          	<h4 class="mt-2">Deposit Accounts</h4>
			          </div>
			          <a href="" data-toggle="modal" data-target=".bd-example-modal-lg" class="float-right btn-create">Create Account</a>

			        </div>
			        <div class="card-body">
			          <div class="table-accounts table-full-width table-responsive">
			            <table class="table">
			              <tbody>
			              	<tr>
			                  <td>
			                    <p>Deposit Type</p>
			                  </td>
			                  <td>
			                    <p>Balance</p>
			                  </td>
			                  <td>
			                    <p>Status</p>
			                  </td>
							</tr>
							
							@foreach($client->deposits as $key=>$cbu)
			                <tr>
			                  <td>
			                    <a href="/deposit/{{$cbu->deposit_id}}/{{$cbu->client_id}}">
			                      <p class="title">{{$cbu->type->name}}</p>
			                    </a>
			                  </td>
			                  <td>
			                   
									{{$cbu->balance}}
								
			                  </td>
			                  <td>
			                    <span class="active position-relative px-2">
			                      {{$cbu->status}}
			                    </span>
			                  </td>
							</tr>
							@endforeach
			              </tbody>
			            </table>
			          </div>
			        </div>
		      </div>

		    	<!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				    	<h4 class="h4">New Loan Account</h4>
				     	<div class="row">
				     		<div class="modal-form-group">
					     		<form>
						     		<div class="col-lg-12">
						     			<label>Disbursement Date</label>
						     			<date-picker></date-picker>
						     		</div>
					     		</form>
				     		</div>
				     	</div>
				    </div>
				  </div>
				</div> -->
		    </div>
	  	</div>
	</div>
@endsection