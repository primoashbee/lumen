@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4 pb-20" id="content-full">
	<div class="card">
		<nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Client</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Loan Account</li>
          </ol>
        </nav>
		<div class="card-header">
			<h1 class="title text-2xl">Nelson Abilgos Tan</h1>
			<h4 class="title text-base">Client ID</h4>
		</div>
		<div class="card-body">

			<form class="row">
				<div class="col-lg-12">
					<h1 class="text-2xl title">New Loan Account</h1>
					<div class="row mt-4">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="loan_products" class="title text-xl">Product</label>
								<select id="loan_products" class="form-control">
									<option value="">Please Select Product</option>
								</select>
							</div>
							<div class="form-group">
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label for="disbursement_date">Disbursement Date</label>
                        		<date-picker id="disbursement_date"></date-picker>
							</div>
							<div class="form-group">
								<label for="repayment_date">First Repayment Date</label>
                        		<date-picker id="repayment_date"></date-picker>
							</div>
						</div>	
					</div>	

					<hr>
						<h1 class="text-2xl title">Loan Terms</h1>
					<div class="row pb-4">
						
						<div class="d-table-row px-3 mt-4">

							<div class="form-group d-table-cell pl-4">
								<label for="loan_amount" class="title text-xl">Loan Amount</label>
								<input type="number" class="form-control" id="loan_amount">
							</div>

							
						</div>
						
						<div class="d-table-row pl-3 mt-4">
							<div class="d-table-cell form-group">
								<label for="installment" class="title text-xl">Number of Installment</label>
								<input type="number" class="form-control" id="installment">
							</div>
							<div class="form-group d-table-cell pl-4">
								<label for="Interest" class="title text-xl">Interest</label>
								<input type="number" class="form-control" id="Interest">
							</div>
						</div>
						
					</div>	
					<hr>
					<h1 class="text-2xl title mt-4">Fees</h1>
					<div class="row px-3 mt-4 pb-4">
						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">MI Fee</label>
							<input type="text" class="form-control">
						</div>
						
						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">MI Premium</label>
							<input type="text" class="form-control">
						</div>

						

						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">DST</label>
							<input type="text" class="form-control">
						</div>

						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">CGLI Fee</label>
							<input type="text" class="form-control">
						</div>

						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">CGLI Premium</label>
							<input type="text" class="form-control">
						</div>

						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">Processing Fee</label>
							<label for="" class="title text-lg">Processing Fee</label>
						</div>
						<div class="d-flex form-group w-full">
							<label for="mi_fee" class="text-lg w-2">Disburse Amount</label>
							<label for="" class="title text-lg">Disbursement Amount</label>
						</div>
					</div>

					<hr>
					<h1 class="title text-2xl">Minimum Deposit Balance</h1>
					<div class="row">
						<div class="d-flex w-8 px-3 mt-4">
							<div class="w-full form-group">
								<label for="deposit_account" class="title text-xl">Deposit Account</label>
								<select id="deposit_account" class="form-control">
									<option value="">MCBU</option>
									<option value="">RCBU</option>
								</select>
							</div>
							<div class="form-group pl-4 w-full">
								<label for="minimum_balance" class="title text-xl">Minimum Balance</label>
								<input type="number" class="form-control w-7" id="minimum_balance">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="notes" class="title text-2xl">Notes</label>
						<textarea class="form-control" id="" cols="30" rows="10"></textarea>	
					</div>
					
					<table class="table" >
		                <thead>
		                    <tr>
		                        <td><p class="title">Installment</p></td>
		                        <td><p class="title">Date</p></td>
		                        <td><p class="title">Principal</p></td>
		                        <td><p class="title">Interest</p></td>
		                        <td><p class="title">Payment Due</p></td>
		                        <td><p class="title">Balance</p></td>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-lg">1</td>
		                        <td class="text-lg">30 Jul 2020</td>
		                        <td class="text-lg">773.20</td>
		                        <td class="text-lg">135.14</td>
		                        <td class="text-lg">908.34</td>
		                        <td class="text-lg">9,226.80</td>
		                    </tr>
		                </tbody>
		            </table>
					
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection