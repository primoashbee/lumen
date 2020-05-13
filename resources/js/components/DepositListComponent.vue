 <template>
        <div class="row">
            <div class="w-100 px-3 mt-6">
                <table class="table" >
                    <thead>
                        <tr>
                            <td><p class="title">Code</p></td>
                            <td><p class="title">Name</p></td>
                            <td><p class="title">Status</p></td>
                            <td><p class="title">Action</p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="deposit in depositList.data">
                            <td>{{deposit.product_id}}</td>
                            <td>{{deposit.name}}</td>
                            <td>
                                <span :class="[deposit.is_active ? 'd_active' : 'd_inactive']" class="text-base">ACTIVE</span>
                            </td>
                        <td>
                            <a :href="toEditDepositProduct(deposit.product_id)" class="btn btn-secondary">
                                    <i class="far text-lg fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="lead float-left text-right" style="color:white">Showing Records {{depositList.from}} - {{depositList.to}} of {{totalRecords}} </p>
                <p class="lead float-right text-right" style="color:white">Total Records: {{totalRecords}} </p>
                <div class="clearfix"></div>
                <paginator :dataset="depositList" @updated="fetch"></paginator>
            </div>

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

<script>
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default{
        data(){
           return { 
                depositList:[],
                hasRecords:false
           }
        },
        methods:{
            toEditDepositProduct(code){
                return '/edit/deposit/'+code
            },
            fetch(page){
                var link= '/deposit/list'
                if(page==undefined){
                    axios.get(link).then(res => {
                        this.depositList = res.data 
                        this.checkIfHasRecords()
                    })
                }else{
                    axios.get(link+'?page='+page)
                    .then(res => {
                        this.checkIfHasRecords()
                        this.depositList = res.data
                    })
                }
            },
            checkIfHasRecords(){
                this.hasRecords = false
                if (this.viewableRecords > 0){
                    this.hasRecords = true
                }
            },
        },
        created(){  
            this.fetch()
        },
        computed:{
            totalRecords(){
                return numeral(this.depositList.total).format('0,0')
            },
            viewableRecords(){
                return Object.keys(this.depositList.data).length
            },
  
        }

    }
</script>