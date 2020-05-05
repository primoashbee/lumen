@extends('layouts.user')

@section('content')

<div class="content pl-32 pr-8 mt-4" id="content-full">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<nav aria-label="breadcrumb">
		          <ol class="breadcrumb">
		            <li class="breadcrumb-item"><a href="">Client Profile</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Deposit Account</li>
		          </ol>
		    	</nav>
				<div class="card-header">

					<div class="row">
						<div class="col-lg-6">
							<h1 class="title text-2xl">Restricted CBU</h1>
						</div>
						<div class="col-lg-6 text-right">
							<a href="" class="btn btn-primary mr-2">Enter Deposit</a>
							<a href="" class="btn btn-primary">Enter Withdrawal</a>
						</div>
					</div>
					<div class="row mt-8 px-4">
						
							<div class="d-inline-block mr-16">
								<p class="title text-lg">Active</p>
					            <p class="text-muted text-lg">Status</p>
							</div>
							<div class="d-inline-block mr-16">
								<p class="title text-lg">RCBU</p>
					            <p class="text-muted text-lg">Deposit Product</p>
							</div>
				            <div class="d-inline-block mr-16">
				                <p class="title text-lg">1000</p>
				                <p class="text-muted text-lg">Balance</p>
				            </div>
				            <div class="d-inline-block">
				                <p class="title text-lg">November 28, 2020</p>
				                <p class="text-muted text-lg">Date Created</p>
				            </div>
						
					</div>
				</div>

				<div class="card-body">
					 <div class="row">
				        <div class="col-md-12">
				                <h5 class="title text-2xl">Transactions</h5>
				                <div class="">
				                     <table class="table" >
						                <thead>
						                    <tr>
						                        <td><p class="title">ID</p></td>
						                        <td><p class="title">Transaction Date</p></td>
						                        <td><p class="title">Type</p></td>
						                        <td><p class="title">Amount</p></td>
						                        <td><p class="title">Balance</p></td>
						                    </tr>
						                </thead>
						                <tbody>
						                    <tr>
						                        <td>
						                        	<p class="title">1</p>
						                        </td>
						                        <td>
						                        	<p class="title">November 28,1995</p>
						                        </td>
						                        <td>
						                        	<p class="title">Deposit</p>
						                        </td>
						                        <td>
						                        	<p class="title">500</p>
						                        </td>
						                        <td>
						                        	<p class="title">1000</p>
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
	</div>
</div>

@endsection