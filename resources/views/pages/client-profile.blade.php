@extends('layouts.user')
@section('content')
	<div class="content content pl-32 pr-8 mt-4" id="content-full">
	  <div class="row">
		    <div class="col-md-8"> 	
		      <div class="card pb-4">
		        <div class="card-header my-2">
		          <div class="d-block text-center client-image">
		            <img src="{{asset($client->profile_picture_path)}}" class="avatar" alt="Profile Photo">
		          </div>
				  <h4 class="px-1 text-center">{{$client->name()}}</h4>
		        </div>
		        <div class="card-body">
		          <div class="content-wrapper">
		            <div class="row">
		              <div class="form-group col-md-2">
		                <p class="title">{{$client->client_id}}</p>
		                <p class="text-muted">Client ID</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">{{$client->nickname}}</p>
		                <p class="text-muted">Nickname</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">{{$client->birthday}}</p>
		                <p class="text-muted">Date Of Birth</p>
		              </div>
		              <div class="form-group col-md-2 p0">
		                <p class="title">{{$client->birthplace}}</p>
		                <p class="text-muted">Birthplace</p>
		              </div>
		              <div class="form-group col-md-4">
		                <p class="title"> {{$client->civil_status}}</p>
		                <p class="text-muted">Marital Status</p>
		              </div>
		            </div>
		            <div class="row my-5">
		              <div class="col-md-4">
		                <p class="title">{{$client->education}}</p>
		                <p class="text-muted">Educational Attainment</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title">{{$client->fb_account}}</p>
		                <p class="text-muted">Facebook Account</p>
		              </div>
		              <div class="col-md-4">
		                <p class="title">{{$client->contact_number}}</p>
		                <p class="text-muted">Phone Number</p>
		              </div>
		            </div>
		            <h3 class="my-3">Address Information</h3>
		            <div class="row my-4">
		              <div class="col-md-6">
		                <p class="title">{{$client->street_address}}</p>
		                <p class="text-muted">Street Address</p>
		              </div>
		              <div class="col-md-6">
		                <p class="title">{{$client->business_address}}</p>
		                <p class="text-muted">Business Address</p>
		              </div>
		            </div>
		            <div class="row px-3">
		              <div class="col-md-3 p0">
		                <p class="title">{{$client->barangay_address}}</p>
		                <p class="text-muted">Barangay</p>
		              </div>
		              <div class="col-md-3">
		                <p class="title">{{$client->city_address}}</p>
		                <p class="text-muted">City</p>
		              </div>
		              <div class="col-md-2">
		                <p class="title">{{$client->province_address}}</p>
		                <p class="text-muted">Province</p>
		              </div>
		              <div class="col-md-2 col-md-offset-2">
		                <p class="title">{{$client->zipcode}}</p>
		                <p class="text-muted">Zip code</p>
		              </div>
		            </div>
		          </div>
		          <div class="col-lg-10 mt-4">
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
			            <a href="" data-toggle="modal" data-target=".bd-example-modal-lg" class="float-right btn-create">Create Account</a>
			          </h4>

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
			                    <a href="">
			                      <p class="title">{{$cbu->type->name	}}</p>
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