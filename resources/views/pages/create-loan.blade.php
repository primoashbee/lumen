@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4 pb-20" id="content-full">
	<div class="card">
		<nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Settings</a></li>
            <li class="breadcrumb-item"><a href="">Loans</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Loan Product</li>
          </ol>
        </nav>
		<div class="card-header">
			<h1 class="title text-2xl">Create Loan Product</h1>
		</div>
		<div class="card-body">

			<form class="row">
				<div class="col-lg-8">
					<h1 class="text-2xl title">Product Information</h1>
					<div class="row mt-4">
						<div class="form-group col-lg-6">
							<label for="loan-code" class="title text-xl">Product Code</label>
							<input type="text" class="form-control text-xl">
						</div>
						<div class="form-group col-lg-6">
							<label for="deposit-name" class="title text-xl">Product Name</label>
							<input type="text" class="form-control text-xl" id="deposit-name">
						</div>
					</div>
					<div class="row mt-4">
						<div class="form-group col-lg-4">
							<label for="valid-until" class="title text-xl">Valid Until</label>
							<date-picker id="valid-until" class="text-xl"></date-picker>
						</div>
						<div class="form-group col-lg-4">
							<label class="text-xl" for="apc">Accounts Per Client</label>
							<input type="number" class="form-control text-xl" id="apc">
						</div>
						<div class="form-group col-lg-4">
							<label class="text-xl" for="mapt">Minimum Loan Amount</label>
							<input type="number" class="form-control text-xl" id="mapt">
						</div>
						<div class="col-lg-12 form-group">
							<label class="title text-xl" for="description">Product Description</label>
							<textarea id="description" class="form-control" cols="30" rows="10"></textarea>
						</div>
					</div>
					<h1 class="text-2xl title">Installments</h1>
					<div class="row mt-4">
						
						<div class="form-group col-lg-4">
							<label class="title text-xl" for="min_installment">Minimum Installment</label>
							<input type="number" class="form-control text-xl" id="min_installment">
						</div>
						<div class="form-group col-lg-4">
							<label class="title text-xl" for="default_installment">Default Installment</label>
							<input type="number" class="form-control text-xl" id="default_installment">
						</div>
						<div class="form-group col-lg-4">
							<label class="title text-xl" for="max_installment">Maximum Installment</label>
							<input type="number" class="form-control text-xl" id="max_installment">
						</div>

						<div class="form-group col-lg-6">
							<label class="title text-xl" for="installment_length">Installment Length</label>
							<input type="number" class="form-control text-xl" id="installment_length">
						</div>
						<div class="form-group col-lg-6">
							<label class="title text-xl" for="installment_method">Installment Method</label>
							<select name="" id="installment_method" class="form-control">
								<option value="days">Days</option>
								<option value="weeks">Weeks</option>
								<option value="months">Months</option>
								<option value="years">Years</option>
							</select>
						</div>

						
					</div>
					
					
					<div class="row mt-4">
						<div class="form-group col-lg-6 d-inline-block">
							<label class="title text-xl" for="interest_rate">Interest Rate</label>
							<input type="text" class="form-control text-xl" id="interest_rate">
							
						</div>
						<div class="form-group col-lg-6 d-inline-block">
							<label class="title text-xl" for="interest_interval">Interest Interval</label>
							<input type="text" class="form-control text-xl" id="interest_interval">
						</div>
						<div class="form-group col-lg-6 d-inline-block">
							<label class="title text-xl" for="grace_period">Grace Period</label>
							<input type="text" class="form-control text-xl" id="grace_period">
						</div>
						<div class="form-group p0 col-lg-6 mt-4 d-table-row">
							<div class="form-check tranch mx-w3 d-table-cell">
		                        <label class="form-check-label" for="allow_tranches">
		                            <input class="form-check-input cb-type" id="allow_tranches" type="checkbox">
		                            <span class="form-check-sign" style="top:1px;">
		                            <span class="check"></span>
		                            </span>
		                            <label class="text-lg title" for="allow_tranches">Allow Tranches</label>
		                        </label>
		                    </div>
		                    <div class="px-3 w-7 d-table-cell">
		                   	 <input type="number" class="form-control mt-3 text-xl" id="number_of_tranches" placeholder="Number of Tranches">
		                    </div>
	                    </div>
					</div>
					<h1 class="text-2xl title">General Ledger Accounts</h1>
	
					<div class="row px-3">
						<div class="col-lg-6 mt-8">
							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Portfolio Active</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>
							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Portfolio In Arrears</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>

							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Portfolio Matured</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6 mt-8">
							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Interest Active</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>
							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Interest In Arrears</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>

							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Interest Matured</label>
								<select id="loan_portfolio_active" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Write Off</label>
								<select id="loan_write_off" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>

							<div class="form-group w-100">
								<label class="title text-lg" for="loan_portfolio_active">Loan Write Off Recovery</label>
								<select id="loan_write_off_recovery" class="form-control">
									<option value="">Select GL Accounts</option>
								</select>
							</div>
						</div>
						
					</div>
					<button type="submit" class="btn btn-primary ml-3">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection