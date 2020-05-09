<template>
	<div class="card">
		 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a>Settings</a></li>
            <li class="breadcrumb-item"><a>Deposits</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Deposit</li>
          </ol>
        </nav>
		<div class="card-header">
			<h1 class="title text-2xl">Create Deposit Product</h1>
		</div>
		<div class="card-body">

			<form class="row">
				<div class="col-lg-8">
					<h1 class="text-2xl title">Product Information</h1>
					<div class="row mt-4">
						<div class="form-group col-lg-6">
							<label for="deposit-code" class="title text-xl">Product Code</label>
							<input type="text" class="form-control text-xl" id="deposit-code" v-model="fields.product_id" v-bind:class="product_idHasError ? 'is-invalid' : ''" v-bind:has-error="product_idHasError ? 'is-invalid' : ''">
						</div>
						<div class="form-group col-lg-6">
							<label for="deposit-name" class="title text-xl">Product Name</label>
							<input type="text" class="form-control text-xl" id="deposit-code" v-model="fields.name" v-bind:class="nameHasError ? 'is-invalid' : ''" v-bind:has-error="nameHasError ? 'is-invalid' : ''">
							
						</div>
					</div>
					<div class="row mt-4">
						<div class="form-group col-lg-3">
							<label for="valid-until" class="title text-xl">Valid Until</label>
							<date-picker id="valid-until" class="text-xl"  v-model="fields.valid_until" v-bind:class="valid_untilHasError ? 'is-invalid' : ''" v-bind:has-error="valid_untilHasError ? 'is-invalid' : ''"  @datePicked="getDate($event, 'birthday')" ></date-picker>
						</div>
						<div class="form-group col-lg-3">
							<label class="text-xl" for="apc">Accounts Per Client</label>
							<input type="number" class="form-control text-xl" id="apc" v-model="fields.accounts_per_client" v-bind:class="accountsPerClientHasError ? 'is-invalid' : ''" v-bind:has-error="accountsPerClientHasError ? 'is-invalid' : ''">
						</div>
						<div class="form-group col-lg-4">
							<label class="text-xl" for="mapt">Min Amount Per Transaction</label>
							<input type="number" class="form-control text-xl" id="mapt" v-model="fields.minimum_amount_per_transaction" v-bind:class="minimumAmountPerTransactionHasError ? 'is-invalid' : ''" v-bind:has-error="minimumAmountPerTransactionHasError ? 'is-invalid' : ''">
						</div>
						<div class="form-group col-lg-2">
							<label class="text-xl" for="interest_rate">Interest Rate</label>
							<input type="number" class="form-control text-xl" placeholder="%" id="interest_rate" v-model="fields.interest_rate" v-bind:class="interestRateHasError ? 'is-invalid' : ''" v-bind:has-error="interestRateHasError ? 'is-invalid' : ''">
						</div>
					</div>
					<div class="row mt-4">
						<div class="form-group col-lg-6 d-inline-block">
							<label class="title text-xl" for="deposit_portfolio">Deposit Portfolio</label>
							<input type="text" class="form-control text-xl" id="deposit_portfolio" v-model="fields.deposit_portfolio" v-bind:class="depositPortfolioHasError ? 'is-invalid' : ''" v-bind:has-error="depositPortfolioHasError ? 'is-invalid' : ''">
						</div>
						<div class="form-group col-lg-6 d-inline-block">
							<label class="title text-xl" for="deposit_interest_expense">Deposit Interest Expense</label>
							<input type="text" class="form-control text-xl" id="deposit_interest_expense" v-model="fields.deposit_interest_expense" v-bind:class="depositInterestHasError ? 'is-invalid' : ''" v-bind:has-error="depositInterestHasError ? 'is-invalid' : ''">
						</div>
					</div>
					<div class="row mt-4">
						<div class="form-group col-lg-6">
							<label class="title text-xl" for="gl_account">Deposit Portfolio Linked To</label>
							<select class="form-control">
								<option>Select GL Account</option>
							</select>
						</div>
						<div class="form-group col-lg-6">
							<label class="title text-xl" for="gl_account">Deposit Interest Expense Linked To</label>
							<select class="form-control">
								<option>Select GL Account</option>
							</select>
						</div>
						<div class="form-group d-inline-block pl-3">
							<div class="p0 form-check">
	                            <label class="form-check-label" for="auto_create">
	                                <input class="form-check-input cb-type" v-model ="fields.auto_create" id="auto_create" type="checkbox">
	                                <span class="form-check-sign">
	                                <span class="check"></span>
	                                </span>
	                                <label for="auto_create" class="text-lg title">Automatically Create for New Client</label>
	                            </label>
	                        </div>
						</div>
						<div class="form-group col-lg-12">
							<label for="description" class="title text-xl">Description</label>
                       		 <textarea value="notes" rows="3" cols="40" v-model="fields.notes" class="form-control"></textarea>
						</div>
						
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	export default{
		data(){
			return{
				fields:{
					name:"",
					product_id:"",
					description:"",
					valid_until:"",
					accounts_per_client:"",
					minimum_amount_per_transaction:"",
					interest_rate:"",
					auto_create:false,
					deposit_portfolio:"",
					deposit_interest_expense:""
				},
				errors:{}
			}
		},
		methods:{
			getDate(value, field){
	           this.fields[field] = value
	        },
		},
		computed:{
			valid_untilHasError(){
            	return this.errors.hasOwnProperty('valid_until')
			},
			product_idHasError(){
				return this.errors.hasOwnProperty('product_id')
			},
			nameHasError(){
				return this.errors.hasOwnProperty('name')
			},
			accountsPerClientHasError(){
				return this.errors.hasOwnProperty('accounts_per_client')
			},
			minimumAmountPerTransactionHasError(){
				return this.errors.hasOwnProperty('minimum_amount_per_transaction')
			},
			interestRateHasError(){
				return this.errors.hasOwnProperty('interest_rate')
			},
			depositPortfolioHasError(){
				return this.errors.hasOwnProperty('deposit_portfolio')
			},
			depositInterestHasError(){
				return this.errors.hasOwnProperty('deposit_interest_expense')
			}
		}
	}
</script>