<template>
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
					<div class="d-details b-btm">
						<h1 class="title text-2xl">Restricted CBU</h1>
						<p class="title text-xl mt-4 pb-4">Status: <span class="active text-lg">ACTIVE</span></p>
					</div>
				</div>
				<div class="col-lg-6 text-right">
					<b-button class="btn btn-primary mr-2" @click="showDepositModal">Enter Deposit</b-button>
					<b-button class="btn btn-primary" @click="showWithdrawalModal">Enter Withdrawal</b-button>
				</div>
			</div>
			<div class="row mt-8 px-4">
				<div class="content-wrapper d-block mb-12 w-100">
					<div class="d-inline-block mr-16">
						<p class="title text-lg">This is description</p>
			            <p class="text-muted text-lg">Description</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">RCBU</p>
			            <p class="text-muted text-lg">Product code</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">0</p>
			            <p class="text-muted text-lg">Accrued Interest</p>
					</div>
		        </div>    
				<div class="content-wrapper d-block w-100 mb-12">
					<div class="d-inline-block mr-16">
						<p class="title text-lg">Active</p>
			            <p class="text-muted text-lg">Status</p>
					</div>
					<div class="d-inline-block mr-16">
						<p class="title text-lg">2%</p>
			            <p class="text-muted text-lg">Interest Rate</p>
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
		</div>

		<div class="card-body">
			 <div class="row">
		        <div class="col-md-12">
		                <h5 class="title text-2xl">Transactions</h5>
		                <div class="">
		                     <table class="table">
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

		<b-modal id="deposit-modal" v-model="showDeposit" size="lg" hide-footer title="Enter Deposit" :header-bg-variant="background" :body-bg-variant="background">
		    <form @submit.prevent="submit">
		        <div class="form-group mt-4">
		        	<label class="text-lg">Branch</label>
                    <v2-select @officeSelected="assignOffice" :list_level="list_level" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
                    <div class="invalid-feedback" v-if="officeHasError">
                        {{ errors.office_id[0]}}
                    </div>
		        </div>
		        <div class="form-group">
		        	<label class="text-lg">Payment Method</label>
                    <select class="form-control" v-bind:class="methodHasError ? 'is-invalid' : ''">
                    	<option>CHOOSE AN OPTION</option>
                    	<option>CASH IN BANK - EAST WEST</option>
                    	<option>CASH IN BANK - CHINABANK</option>
                    	<option>CASH IN BANK - COMMERCE</option>
                    </select>
		        </div>

		        <div class="form-group">
		        	<label class="text-lg">Amount</label>
                    <input type="text" class="form-control" v-bind:class="amountHasError ? 'is-invalid' : ''">
		        </div>
		        <button type="submit" class="btn btn-primary">Submit</button>
		    </form>
		</b-modal>

		<b-modal id="withdrawal-modal" v-model="showWithdrawal" size="lg" hide-footer title="Enter Withdrawal" :header-bg-variant="background" :body-bg-variant="background">
		    <form @submit.prevent="submit">
		        <div class="form-group">
		        	<label class="text-lg">Branch</label>
                    <v2-select @officeSelected="assignOffice" :list_level="list_level" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
                    <div class="invalid-feedback" v-if="officeHasError">
                        {{ errors.office_id[0]}}
                    </div>
		        </div>
		        <div class="form-group">
		        	<label class="text-lg">Payment Method</label>
                    <select class="form-control">
                    	<option>CHOOSE AN OPTION</option>
                    	<option>CASH IN BANK - EAST WEST</option>
                    	<option>CASH IN BANK - CHINABANK</option>
                    	<option>CASH IN BANK - COMMERCE</option>
                    </select>
                    <div class="invalid-feedback" v-if="methodHasError">
                        {{ errors.method[0]}}
                    </div>
		        </div>

		        <div class="form-group">
		        	<label class="text-lg">Amount</label>
                    <input type="number" class="form-control">
                    <div class="invalid-feedback" v-if="amountHasError">
                        {{ errors.code[0]}}
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
    
</style>
<script type="text/javascript">
	export default{
		props:['list_level'],
		data(){
			return{
				showDeposit:false,
				showWithdrawal:false,
				variants: ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark'],
                background:'dark',
                fields:{
                	"office_id":"",	
            	},
                errors:{}
			}
		},
		methods:{
			showDepositModal(){
				this.showDeposit = true;
			},
			showWithdrawalModal(){
				this.showWithdrawal = true;
			},
			assignOffice(value){
                this.fields.office_id = value['id']
            }
		},
		computed:{
			hasErrors(){
                return Object.keys(this.errors).length > 0;
            },
            officeHasError(){
                return this.errors.hasOwnProperty('office_id')
            },
            methodHasError(){
                return this.errors.hasOwnProperty('method')
            },
            amountHasError(){
            	return this.errors.hasOwnProperty('amount')
            }
		}
	}
</script>