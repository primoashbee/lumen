<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <label for="" style="color:white" class="lead mr-2">Filter:</label>
                <v2-select @officeSelected="assignOffice" class="d-inline-block" style="width:500px;" v-model="office_id"></v2-select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="product_id" > Product </label>
                    <loan-product-list id="product_id" @selected="selected"></loan-product-list>
                </div>
            </div>
            <div class="col-lg-2">
            <div class="form-group">
                <label for="disbursement_date">Disbursement Date</label> 
                <input type="date" class="form-control" v-model="form.disbursement_date">
            </div>
            <div class="form-group">
                <label for="repayment_date">First Repayment Date</label> 
                <input type="date" class="form-control" v-model="form.first_payment">
            </div>
        </div>

        <div class="row pb-4">
  
            
            <div class="d-table-row pl-3 mt-4">
                <div class="d-table-cell form-group">
                    <label for="installment" class="title text-xl">Number of Installment</label>
                    <select id="installment" class="form-control" v-model="form.number_of_installments">
                        <option :value="null"> Please Select</option>
                        <option v-for="item in installment_list" :value="item.installments" :key="item.id"> {{item.installments}}</option>
                    </select>
                </div>
                <div class="form-group d-table-cell pl-4">
                    <label for="Interest" class="title text-xl">Interest</label>
                    <input type="text" class="form-control" id="Interest" readonly :value="selected_interest">
                </div>
            </div>
            
        </div>	
      
 
        </div>

        
        <div class="w-100 px-3 mt-6" >
            
            <table class="table" >
                <thead>
                    <tr>
                        <td><p class="title">#</p></td>
                        <td><p class="title">Client ID</p></td>
                        <td><p class="title">Name</p></td>
                        <td><p class="title">Linked To</p></td>
                        <td ><p class="title">Amount</p></td>
                    </tr>
                </thead>
                <tbody v-if="hasRecords">
                    <tr v-for="client in lists.data" :key="client.client_id">
                        <td><input type="checkbox" :id="client.client_id" @change="checked(client,$event)"></td>
                        <td><label :for="client.client_id">{{client.client_id}}</label></td>
                        <td class="text-lg"><a class="text-lg" :href="clientLink(client.client_id)">{{client.firstname + ' ' + client.lastname}}</a></td>
                        <td class="text-lg">{{client.office.name}}</td>
                        <td class="text-lg" style="max-width:50px"><amount-input :disabled="inputDisabled(client.id) "@amountEncoded="amountEncoded" :add_class="errorClass(client.id)"  :account_info="client" :tabindex="key+1" ></amount-input></td>
                    </tr>
                </tbody>
            </table>
            <p class="lead float-left text-right" style="color:white">Showing Records {{lists.from}} - {{lists.to}} of {{totalRecords}} </p>
            <p class="lead float-right text-right" style="color:white">Total Records: {{totalRecords}} </p>
            <div class="clearfix"></div>
            <paginator :dataset="lists" @updated="fetch"></paginator>
        </div>
        
        <button class="btn btn-primary" @click="submit">Create</button>
        <loading :is-full-page="true" :active.sync="isLoading" ></loading>
    </div>
</template>

<script>

import SelectComponentV2 from './SelectComponentV2';
import Swal from 'sweetalert2';
import Paginator from './PaginatorComponent';
import vueDebounce from 'vue-debounce'

Vue.use(vueDebounce, {
  listenTo: 'input'
})

import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
import AmountInputComponent from './AmountInputComponent.vue';
import LoanProduct from './Settings/LoanProduct.vue';


export default {
    data(){
        return {
            code: null,
            errors: null,
            loan_product_id:null,
            office_id: "",
            lists: [],  
            isLoading:false,
            query:"",
            installment_list: [],
            toClient: '/client/',
            form  : {
                accounts : [],
                loan_id:null,
                disbursement_date:null,
                first_payment:null,
                interest_rate:null,

            },
            key: 1,
            rates: []
        }
    },
    components:{
        Loading,
        AmountInputComponent,
    },
    methods :{
        submit(e){
            e.preventDefault()
            this.isLoading=true
            axios.post('/bulk/create/loans',this.form)
            .then(res=>{
                this.isLoading = false
                
                Swal.fire(
					'Success',
					res.data.msg,
					'success'
                )
               .then(()=>{
                    location.reload()
                })
            })
            .catch(err=>{
                this.isLoading = false
                
                this.errors = err.response.data.errors || {}
                Swal.fire(
					'Error',
					'Check input errors',
					'error'
				)
            })
        },
        checked(account,event){
            if(event.target.checked){
                this.form.accounts.push(account)
            }else{
                this.form.accounts = this.form.accounts.filter(x=>{
                    return x.id != account.id
                })
            }
            
        },
        errorClass(){

        },
        selected(e){
            this.code = e.code
            this.loan_product_id = e.id
            this.installment_list = e.rates
            this.form.loan_id = e.id
        },
        amountEncoded(value){
            
			var amount = value['amount'];
            var account_id = value['client_id'];
            this.form.accounts.map(x=>{
                if(x.client_id == account_id){
                    x.amount = amount
                }
            })
			// if(this.isInFormAccounts(account_id)){
			// 	var index = this.form.accounts.findIndex(x=> {return x.id ==account_id} )
			// 	this.form.accounts[index].amount = amount
			// }

		},

		inputDisabled(id){
			return this.form.accounts.filter(x=>{
				return x.id ==id
			}).includes(id)
		},        
        clientLink(client_id){
            return this.toClient + client_id
        },


        assignOffice(value){
            this.office_id = value['id']
            this.fetch()
        },
 

        fetch(page){
            
            if(page==undefined){
                axios.get(this.queryString)
                .then(res => {
                    this.lists = res.data
                    // this.checkIfHasRecords()
                    this.isLoading =false
                })
            }else{
                axios.get(this.queryString+'&page='+page)
                .then(res => {
                    this.lists = res.data
                    // this.checkIfHasRecords()
                    this.isLoading =false
                })
            }

        },
        url(page=1){
            return `/clients/list?office_id=`+this.office_id+`&page=`+page
        },
        
    },
    computed : {
        hasRecords(){
            return this.lists.hasOwnProperty('data');
        },
        queryString(){
            var str ="?limited=true&"
            var params_count=0
            if(this.office_id!=""){
                params_count++
                str+="office_id="+this.office_id
            }
            if(this.query!=""){
                params_count++
                if(params_count > 1){
                    str+="&search="+this.query
                }else{
                    str+="search="+this.query
                }
            }
            return '/clients/list'+str
        },
        totalRecords(){
            return numeral(this.lists.total).format('0,0')
        },
        viewableRecords(){
            return Object.keys(this.lists.data).length
        },
        selected_interest(){
            let vm = this;
			if(vm.installment_list==null){
				return null;
			}

			var rate = null
			vm.installment_list.map(x=>{ 
				if(x.installments == vm.form.number_of_installments){
					rate = x.rate;
				}
			});
			return rate;

        }

    }
}
</script>