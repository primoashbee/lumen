<template>
	<div class="card">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Payment Methods</li>
		  </ol>
		</nav>
		<div class="card-header">
			<div class="row">
				<div class="col-lg-6">
					<h1 class="title text-2xl">Payment Methods</h1>
				</div>	
				<div class="col-lg-6">
					<a href="" class="btn btn-primary float-right">Create New Payment Method</a>
				</div>	
			</div>
		</div>

		<div class="card-body">
			<div class="profile-menu-tabs"> 
				<ul class="nav nav-tabs" role="tablist">
	                <li class="nav-item">
	                    <a class="nav-link active" id="payment-methods" data-toggle="tab" href="#personal" role="tab" aria-controls="home" aria-selected="true">Payment Methods List</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" id="default-payment-methods" data-toggle="tab" href="#contact" role="tab" aria-controls="profile" aria-selected="false">Default Payment Method Per Branch</a>
	                </li>
	            </ul>
            </div>
             <div class="tab-content py-3 px-3 px-sm-0 mt-4" id="nav-tabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="nav-home-tab">
                	<form class="table-responsive">
	             		<table class="table">
			                <thead>
			                    <tr>
			                    	<td><p class="text-xl title">Status</p></td>
			                        <td><p class="text-xl title">Payment Method</p></td>
			                        <td><p class="text-xl title">Disbursement</p></td>
			                        <td><p class="text-xl title">Repayment</p></td>
			                        <td><p class="text-xl title">Recovery</p></td>
			                        <td><p class="text-xl title">Deposit</p></td>
			                        <td><p class="text-xl title">Withdrawal</p></td>
			                        <td><p class="text-xl title">Action</p></td>
			                    </tr>
			                </thead>
			                <tbody>
			                    <tr>
			                    	<td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="status">
					                                <input class="form-check-input cb-type" v-model="selectAll" @click="selectAllTransactions" id="status" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td><p class="title text-lg">CASH IN BANK - BDO</p></td>
			                        <td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="disbursement">
					                                <input class="form-check-input cb-type" v-model="transactions.disbursement" id="disbursement" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="repayment">
					                                <input class="form-check-input cb-type" v-model="transactions.repayment" id="repayment" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="recovery">
					                                <input class="form-check-input cb-type" v-model="transactions.recovery" id="recovery" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="deposit">
					                                <input class="form-check-input cb-type" v-model="transactions.deposit" id="deposit" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td>
			                        	<div class="form-group">
			                        		<div class="form-check">
					                        	<label for="withdrawal">
					                                <input class="form-check-input cb-type" v-model="transactions.withdrawal" id="withdrawal" type="checkbox">
					                                <span class="form-check-sign">
					                                </span>
					                            </label>
				                            </div>
			                            </div>
			                        </td>
			                        <td>
			                        	<b-button @click="showModal">
		                                    <i class="far fa-edit"></i>
		                                </b-button>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>  
		            </form>  
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="nav-profile-tab">
                	<form class="table-responsive">
	             		<table class="table">
			                <thead>
			                    <tr>
			                        <td><p class="text-xl title">Branch</p></td>
			                        <td><p class="text-xl title">Disbursement</p></td>
			                        <td><p class="text-xl title">Repayment</p></td>
			                        <td><p class="text-xl title">Recovery</p></td>
			                        <td><p class="text-xl title">Deposit</p></td>
			                        <td><p class="text-xl title">Withdrawal</p></td>
			                        <td><p class="text-xl title">Action</p></td>
			                    </tr>
			                </thead>
			                <tbody>
			                    <tr>
			                        <td><p class="title text-lg">Angeles</p></td>
			                        <td>
			                        	<p class="title text-lg">CASH IN BANK - EAST WEST</p>
			                        </td>
			                        <td>
			                        	<p class="title text-lg">CASH IN BANK - BDO</p>
			                        </td>
			                        <td>
			                        	<p class="title text-lg">CASH IN BANK - EAST WEST</p>
			                        </td>
			                        <td>
			                        	<p class="title text-lg">CASH IN BANK - EAST WEST</p>
			                        </td>
			                        <td>
			                        	<p class="title text-lg">CASH IN BANK - EAST WEST</p>
			                        </td>
			                        <td>
			                        	<b-button @click="showBranchPaymentMethodModal">
		                                    <i class="far fa-edit"></i>
		                                </b-button>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>  
		            </form>  
                </div>
             </div>

             <!-- PAYMENT METHOD MODAL -->

             <b-modal id="payment-method-modal" v-model="show" size="lg" hide-footer title="Edit Payment Method" :header-bg-variant="background" :body-bg-variant="background">
                <form @submit.prevent="submit">
                    <div class="form-group">
                    	<label class="text-xl" for="name">Payment Method Name</label>
                    	<input type="text" class="form-control text-xl">
                    </div>
                    <div class="form-group">
                    	<label class="text-xl">Linked to GL Account:</label>
                    	<select class="form-control">
                    		<option value="">Select GL Account</option>
                    		<option value="">Select GL Account</option>
                    	</select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </b-modal>

			<!-- BRANCH PAYMENT METHOD MODAL  -->

            <b-modal id="branch-ayment-method-modal" v-model="showBranchPaymentMethod" size="lg" hide-footer title="Edit Branch Payment Method" :header-bg-variant="background" :body-bg-variant="background">
                <form @submit.prevent="submit">
                    <div class="form-group">
                    	<label class="title text-lg" for="name">Disbursement</label>
                    	<payment-methods payment_type="for_deposit" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
						<div class="invalid-feedback" v-if="paymentMethodHasError">
	                        {{ errors.payment_method[0]}}
	                    </div>
	                </div>    
                    <div class="form-group">
                    	<label class="title text-lg">Repayment</label>
                    	<payment-methods payment_type="for_deposit" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
						<div class="invalid-feedback" v-if="paymentMethodHasError">
	                        {{ errors.payment_method[0]}}
	                    </div>
	                </div>    
                    <div class="form-group">
                    	<label class="title text-lg">Recovery</label>
                    	<payment-methods payment_type="for_deposit" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
						<div class="invalid-feedback" v-if="paymentMethodHasError">
	                        {{ errors.payment_method[0]}}
	                    </div>
	                </div>    
                    <div class="form-group">
                    	<label class="title text-lg">Deposit</label>
                    	<payment-methods payment_type="for_deposit" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
						<div class="invalid-feedback" v-if="paymentMethodHasError">
	                        {{ errors.payment_method[0]}}
	                    </div>
	                </div>    
                    <div class="form-group">
                    	<label class="title text-lg">Withdrawal</label>
                    	<payment-methods payment_type="for_deposit" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
						<div class="invalid-feedback" v-if="paymentMethodHasError">
	                        {{ errors.payment_method[0]}}
	                    </div>
	                </div>    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </b-modal>
		</div>
	</div>
</template>
<style type="text/css">
	tr td .form-check-sign{
		position: absolute;
	}
	tr td .form-check-sign,.form-check .form-check-sign::before,.form-check .form-check-sign::after{
		top: 5px;
	}

</style>
<script type="text/javascript">
	export default{
		data(){
			return{
				show:false,
				fields:{
					payment_method:null,
				},
				transactions:{
					disbursement:false,
					repayment:false,
					deposit:false,
					withdrawal:false,
					recovery:false
				},
				selectAll:false,
				showBranchPaymentMethod:false,
				variants: ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark'],
                background:'dark',
                errors:{}
			}
		},
		methods:{
			showModal(){
				this.show= true
			},
			showBranchPaymentMethodModal(){
				this.showBranchPaymentMethod = true
			},
			paymentSelected(value){
				this.fields.payment_method = value['id']
			},
			selectAllTransactions(){
				var vm = this.transactions;
				$.each(this.transactions, function(k, v){
					vm[k] = !v
				})
			}
		},
		computed:{
			paymentMethodHasError(){
				return this.errors.hasOwnProperty('payment_method')
			}
		}
	}
</script>