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
				<div class="row">
					<div class="col-lg-4 profile-wrapper pl-8 pr-24">
						<div class="text-center profile-picture">
			            	<img src="{{asset($client->profile_picture_path)}}" class="w-100 img-thumbnail" alt="Profile Photo">
			            </div>
			            <div class="mt-8">
			            	<h5 class="title text-2xl">Personal Details</h5>
			            	<div class="p-details mt-4">
			            		<p class="title text-lg">Birthday</p>
				                <p class="text-muted text-lg">{{$client->birthday}}</p>
				            </div>
				            <div class="p-details mt-4">
			            		<p class="title text-lg">Birthplace</p>
				                <p class="text-muted text-lg">{{$client->birthplace}}</p>
				            </div>
				            <div class="p-details mt-4">
			            		<p class="title text-lg">Gender</p>
				                <p class="text-muted text-lg">{{$client->gender}}</p>
				            </div>
				            <div class="p-details mt-4">
			            		<p class="title text-lg">Civil Status</p>
				                <p class="text-muted text-lg">{{$client->civil_status}}</p>
				            </div>
				            <div class="p-details mt-4">
			            		<p class="title text-lg">Educational Attainment</p>
				                <p class="text-muted text-lg">{{$client->education}}</p>
				            </div>
				            <div class="p-details mt-4">
			            		<p class="title text-lg">Facebook Account </p>
				                <p class="text-muted text-lg">{{$client->fb_account}}</p>
				            </div>
			            </div>
					</div>

					<div class="col-lg-8 profile-wrapper">
						<a href="/edit/client/{{$client->client_id}}" type="submit" class="btn btn-primary float-right mr-4">Edit Client</a>
						<div class="p-details">
							<p class="title text-2xl">{{$client->name()}}</p>
							<p class="text-muted text-base">Nickname: {{$client->nickname}}</p>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="p-details mt-4 d-inline-block file-input-signature">
				            		<p class="title text-xl mb-2">Signature</p>
					            	<img src="{{asset($client->signature_path)}}" class="w-100 img-thumbnail" alt="Profile Photo">
					            </div>
							</div>
							<div class="col-lg-6">
								<div class="d-inline-block p-details mt-4 rating">
									<p class="title text-xl">Rating</p>
									 <i class="star-1">★</i>
									  <i class="star-2">★</i>
									  <i class="star-3">★</i>
									  <i class="star-4">★</i>
									  <i class="star-5">★</i>
								</div>
								<div class="p-details mt-4">
									<p class="title text-xl">Created at</p>
									<p class="text-muted text-lg">{{$client->created_at->format('F, j Y')}} - {{$client->created_at->diffForHumans()}}</p>
								</div>
								<div class="p-details mt-2">
									<p class="title text-xl">Status: <span class="active-status text-lg">ACTIVE</span></p>
								</div>
							</div>
						</div>

						
						


						<div class="profile-menu-tabs mt-8 pr-8">
							<ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="home" aria-selected="true">Business 
                                    Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="profile" aria-selected="false">Contact Information</a>
                                </li>
                            </ul>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
			                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="nav-home-tab">
			                 		<div class="p-details">
			                 			<span class="title text-xl mr-8">Address:</span>
										<span class="text-muted text-lg">{{$client->business_address}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Business Type:</span>
										<span class="text-muted text-lg">{{$client->household_income->service_type}}</span>
			                 		</div>
			                 		

			                    </div>
			                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="nav-profile-tab">
			                      	<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Phone Number:</span>
										<span class="text-muted text-lg">{{$client->contact_number}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Street Address:</span>
										<span class="text-muted text-lg">{{$client->street_address}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Barangay:</span>
										<span class="text-muted text-lg">{{$client->barangay_address}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">City:</span>
										<span class="text-muted text-lg">{{$client->city_address}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Province:</span>
										<span class="text-muted text-lg">{{$client->province_address}}</span>
			                 		</div>
			                 		<div class="p-details mt-4">
			                 			<span class="title text-xl mr-8">Zipcode:</span>
										<span class="text-muted text-lg">{{$client->zipcode}}</span>
			                 		</div>
			                    </div>
			                 </div>
						</div>
					</div>
				</div>
		        <div class="p-details mt-8 p-4">
		        	<p class="title text-2xl mb-2">Notes</p>
		        	<p>{{$client->notes}}</p>
		        </div>
		      </div>
		    </div>

		    <div class="col-md-4">
		      <div class="card">
		        <div class="card-header">
		          <div class="float-left text-center">
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
							  <a href="{{route('client.deposit',[$cbu->client_id,$cbu->id])}}">
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
							<tr style="border:none;">
								<td class="text-right pr-2">
									Total
								</td>
								<td class="">
									{{$client->totalDeposits()}}
								</td>
							</tr>
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