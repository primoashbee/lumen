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
        }
    }
}
</script>