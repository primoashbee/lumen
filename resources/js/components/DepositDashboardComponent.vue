<template>
	<div class="card">
		<nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a :href="clientLink">Client Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deposit Account</li>
          </ol>
    	</nav>
		<div class="card-header">

			<div class="row">
				<div class="col-lg-6">
					<div class="d-details b-btm">
						<h1 class="title text-4xl">{{account_info.type.name}}</h1>
						<h1 class="italic text-2xl">{{account_info.client_id + '-' + account_info.client.firstname + ' ' +account_info.client.lastname}}</h1>
						<p class="title text-xl mt-4 pb-4">Status: <span class="badge-pill badge-success">ACTIVE</span></p>
					</div>
				</div>
				<div class="col-lg-6 text-right">
					<b-button class="btn btn-primary mr-2" @click="postInterest" v-if="this.account_info.accrued_interest > 0">Post Interest</b-button>
					<b-button class="btn btn-primary mr-2" @click="showModal('deposit')">Enter Deposit</b-button>
					<b-button class="btn btn-primary" @click="showModal('withdraw')">Enter Withdrawal</b-button>
				</div>
			</div>
			<div class="row mt-8 px-4">
				<div class="content-wrapper d-block mb-12 w-100">
					<div class="d-inline-block mr-16">
						<p class="title text-lg">{{account_info.type.description}}</p>
			            <p class="text-muted text-lg">Description</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">{{account_info.type.product_id}}</p>
			            <p class="text-muted text-lg">Product code</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">{{account_info.accrued_interest}}</p>
			            <p class="text-muted text-lg">Accrued Interest</p>
					</div>
		        </div>    
				<div class="content-wrapper d-block w-100 mb-12">
					<div class="d-inline-block mr-16">
						<p class="title text-lg">Active</p>
			            <p class="text-muted text-lg">Status</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">{{account_info.type.interest_rate}}</p>
			            <p class="text-muted text-lg">Interest Rate (per annum)</p>
					</div>
		            <div class="d-inline-block mr-16">
		                <p class="title text-lg">{{account_info.balance}}</p>
		                <p class="text-muted text-lg">Balance</p>
		            </div>
		            <div class="d-inline-block">
		                <p class="title text-lg">{{account_info.created_at}}</p>
		                <p class="text-muted text-lg">Date Created</p>
		            </div>
		        </div>  
			</div>
		</div>

		<div class="card-body">
			 <div class="row">
		        <div class="col-md-12">
		                <h5 class="title text-2xl">Transactions</h5>
		                <div class="">
		                     <table class="table">
				                <thead>
				                    <tr>
				                        <td><p class="title">#</p></td>
				                        <td><p class="title">ID</p></td>
				                        <td><p class="title">Repayment Date</p></td>
				                        <td><p class="title">Transaction Date</p></td>
				                        <td><p class="title">Type</p></td>
				                        <td><p class="title">Amount</p></td>
				                        <td><p class="title">Balance</p></td>
				                        <td><p class="title">Payment Method</p></td>
				                        <td><p class="title">Posted By</p></td>
				                    </tr>
				                </thead>
				                <tbody>
				                    <tr v-for="(item, index) in account_info.transactions" :key="item.id" >
				                        <td>
				                        	<p class="title text-lg">{{account_info.transactions.length - index}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.transaction_id}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.repayment_date}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.created_at}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.transaction_type}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">
												<span class="badge badge-pill" v-bind:class="rowClass(item)">{{item.amount}}</span>
											</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">
												<span class="badge badge-pill badge-primary">
													{{item.balance}}
												</span>
											</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.payment_method.name}}</p>
				                        </td>
				                        <td>
				                        	<p class="title text-lg">{{item.posted_by.fullname}}</p>
				                        </td>

				                    </tr>
									
				                </tbody>
				            </table>
		                </div>
		        </div>
		    </div>
		</div>

		<b-modal id="deposit-modal" v-model="modal.modalState" size="lg" hide-footer :title="modal.modal_title" :header-bg-variant="background" :body-bg-variant="background" >
		    <form @submit.prevent="submitDeposit">
		        <div class="form-group mt-4">
		        	<label class="text-lg">Branch</label>
                    <v2-select @officeSelected="assignOffice" :list_level="list_level" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
                    <div class="invalid-feedback" v-if="officeHasError">
                        {{ errors.office_id[0]}}
                    </div>
		        </div>
		        <div class="form-group">
		        	<label class="text-lg">Payment Method</label>
					<payment-methods :payment_type="payment_type" @paymentSelected="paymentSelected" v-bind:class="paymentMethodHasError ? 'is-invalid' : ''" ></payment-methods>
					<div class="invalid-feedback" v-if="paymentMethodHasError">
                        {{ errors.payment_method[0]}}
                    </div>
		        </div>

		        <div class="form-group">
		        	<label class="text-lg">Amount</label>
                    <input type="text" class="form-control" v-model="fields.amount" v-bind:class="amountHasError ? 'is-invalid' : ''">
					<div class="invalid-feedback" v-if="amountHasError">
                        {{ errors.amount[0]}}
                    </div>
		        </div>
		        <div class="form-group">
		        	<label class="text-lg">Repayment Date</label>
                    <input type="date" class="form-control" v-model="fields.repayment_date" v-bind:class="repaymentDateHasError ? 'is-invalid' : ''">
					<div class="invalid-feedback" v-if="repaymentDateHasError">
                        {{ errors.repayment_date[0]}}
                    </div>
				</div>
		        <button type="submit" class="btn btn-primary">Submit</button>
		    </form>
		</b-modal>

	</div>

	
</template>
<style type="text/css">
    @import "~vue-multiselect/dist/vue-multiselect.min.css";
    .modal-body .close,.modal-header .close{
        color: #fff!important;
    }
    .modal.fade.show{
        background: rgba(255,255,255,0.3);
    }
    .modal-content{
        border-color: #fff;
    }
    .modal-title{
        font-size: 1.4rem;
    }
    .multiselect__tags{
      border-color:#2b3553!important;
    }
    .multiselect__input,.modal .multiselect__single, .multiselect__tags{
      background: transparent!important;
      
    }
	.btn-danger{
		margin-right:20px;
	}
	.badge {
		font-size:100%;
	}
    
</style>
<script type="text/javascript">
import Swal from 'sweetalert2';
	export default{
		props:['deposit_id','account_info'],
		data(){
			return{
				variants: ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark'],
				background:'dark',
				payment_type: null,
				list_level:'branch',
                modal:{
					modalState:false,
					modal_title:null,
				},
				fields: {
					office_id: null,
					type:null,
					payment_method: null,
					amount: null,
					deposit_account_id: null,
					repayment_date: null
				},
                errors:{}
			}
		},

		created(){
			this.fields.deposit_account_id = this.account_info.id
		},
		methods:{
			rowClass(item){
				if(item.transaction_type=="Withdraw"){
					return 'badge-danger';
				}else if(item.transaction_type=="Deposit"){
					return 'badge-success';
				}else{
					return 'badge-info';
				}
				
			},
			postInterest(){
			
				var vm = this;
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton: 'btn btn-danger'
					},
					
					buttonsStyling: true,
					
					})

					swalWithBootstrapButtons.fire({
					html: 
						`
						<table class="table table-condensed">
						<tbody>
						<thead>
							<th class="text-right" style="width:50%;font-weight:900" >Particulars</th>
							<th class="text-left" style="width:50%;font-weight:900">Amount</th>
						</thead>
						<tr>
							<td class="text-right pr-2">Current Balance: </td>
							<td class="text-left">`+vm.account_info.balance+`</td>
						</tr>
						<tr>
							<td class="text-right pr-2">Accrued Interest: </td>
							<td class="text-left">`+vm.currency +" "+vm.account_info.accrued_interest+`</td>
						</tr>
						<tr style="border:none">
							<td class="text-right pr-2" style="font-weight:900">Balance after Posting: </td>
							<td class="text-left" style="font-weight:900">`+vm.account_info.new_balance_formatted+`</td>
						</tr>
						</tbody>
						</table>
						`,
						
					title: '<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">Are you sure you want to post interest? (Can\'t revert this)</span> ',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Yes',
					cancelButtonText: 'No',
					
					reverseButtons: true
					}).then((result) => {
					if (result.value) {
						axios.post('/deposit/account/post/interest',{
							'deposit_account_id':vm.account_info.id
							}
						)
						.then(res=>{
							swalWithBootstrapButtons.fire(
							'<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">Posted!</span>',
							'Accrued Interest Posted',
							'success'
							)
						})
						.catch(err=>{
							console.log(err)
						})
					} else if (
						/* Read more about handling dismissals below */
						result.dismiss === Swal.DismissReason.cancel
					) {
						swalWithBootstrapButtons.fire(
						'<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">Cancelled</span>',
						'Transaction cancelled',
						'error'
						)
					}
				})
			},
			showModal(transaction){
				this.modal.modalState = true
				if(transaction=="deposit"){
					this.modal.modal_title="Enter Deposit"
					this.fields.type="deposit"
					this.payment_type="for_deposit"
				}else{
					this.modal.modal_title="Enter Withdrawal"
					this.fields.type="withdraw"
					this.payment_type="for_withdrawal"
				}

			},
			paymentSelected(value){
				this.fields.payment_method = value['id']
			},
			assignOffice(value){
                this.fields.office_id = value['id']
			},
			submitDeposit(){
				axios.post(
					'/deposit/'+this.account_info.id,
					this.fields)
					.then(res=>{
						Swal.fire({
							icon: 'success',
							title: '<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">Success!</span>',
							text: res.data.msg,
							confirmButtonText: 'OK'
						})
						.then(res=>{
							location.reload();
						})
					})
					.catch(error=>{
						
						this.errors = error.response.data.errors || {}
					})
			}
		},
		computed:{
			hasErrors(){
                return Object.keys(this.errors).length > 0;
            },
            officeHasError(){
                return this.errors.hasOwnProperty('office_id')
            },
            paymentMethodHasError(){
                return this.errors.hasOwnProperty('payment_method')
            },
            amountHasError(){
            	return this.errors.hasOwnProperty('amount')
            },
            repaymentDateHasError(){
            	return this.errors.hasOwnProperty('repayment_date')
            },
            clientLink(){
				return '/client/'+this.account_info.client_id
			},
			currency(){
				return this.account_info.balance.substr(0,1)
			}
		},
		watch: {
			'modal.modalState' : function(){
				if(!this.modal.modalState){
					this.errors = []
					this.fields.office_id = null,
					this.fields.type=null,
					this.fields.payment_method = null,
					this.fields.amount = null,
					this.fields.repayment_date = null
				}
			}
		}
	}
</script>