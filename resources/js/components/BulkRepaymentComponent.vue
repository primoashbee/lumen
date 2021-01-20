<template>
    <div>
        <form @submit.prevent="fetch">
            <div class="row">
                <div class="col-4">
                    <label for="" style="color:white" class="lead">Filter:</label>
                    <v2-select @officeSelected="assignOffice"></v2-select>
                </div>
                <div class="col-3">
                    <label for="date" style="color:white"  class="lead" >Date</label>
                    <input type="date" id="date" class="form-control" v-model="request.date" />
                </div>
                <div class="col-4">
                    <label for="product" style="color:white"  class="lead" >Product</label>
                    <loan-product-list @selected="productSelected"></loan-product-list>
                </div>
                <div class="col-1">
                    
                    <button class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
        </form>

        <div class="w-100 px-3 mt-6" >
            <table class="table table-striped">
                <thead>
                    <td>#</td>
                    <td><p class="title">Loan</p></td>
                    <td><p class="title">Client ID</p></td>
                    <td><p class="title">Name</p></td>
                    <td><p class="title">Principal</p></td>
                    <td><p class="title">Interest</p></td>
                    <td><p class="title">Total</p></td>
                    <td><p class="title">Payment</p></td>
                </thead>
                <tbody v-if="this.hasRecords">
                    <tr v-for="(item, key) in list" :key="item.id">
                        <td> <input type="checkbox"></td>
                        <td><p class="title"> </p></td>
                        <td><p class="title"> {{item.client_id}}</p></td>
                        <td><p class="title"> {{item.client.full_name}}</p></td>
                        <td><p class="title"> {{item.repayment_info._principal}}</p></td>
                        <td><p class="title"> {{item.repayment_info._interest}}</p></td>
                        <td><p class="title"> {{item.repayment_info._amount_due}}</p></td>
                        <td><input type="number" class="form-control"></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            request : {
                office_id: null,
                date: null,
                product_id:null
            },
            list: null,
            url: '/loans/scheduled/list'
        }
    },
    methods : {
        assignOffice(value){
            this.request.office_id = value['id']
        },
        productSelected(value){
            this.request.product_id = value.id
        },
        fetch(){
            if(this.canFetch){
               
                axios.post(this.url,this.request)
                .then(res=>{
                    this.list = res.data.list
                    console.log(res.data.list)
                })
                .catch(err=>{
                    
                })
            }
        }   
    },
    computed : {
        canFetch(){
            var keys = Object.keys(this.request);
            var check = 0;
            keys.map(x=>{
                if(this.request[x] === null){
                    check++;
                }
            })

            return check == 0;
        },
        totalAccounts(){
            if(this.list === null){
                return 0;
            }
            return this.list.length
        },
        hasRecords(){
              if(this.list === null){
                return false;
            }
            return this.totalAccounts > 0
        }
    }
}
</script>