 <template>
        <div class="row">
            <div class="col-lg-6 float-left d-flex">
                <label for="" style="color:white" class="lead mr-2">Search:</label>
                <input type="text" id="office_client" class="form-control border-light pb-2"/>
            </div>
            <div class="col-lg-6 text-right">
                <a :href="createOfficeLink()" type="submit" class="btn btn-primary px-8">Create {{this.officeName(this.level)}}</a>
            </div>  
            <div class="w-100 px-3 mt-6">
                <table class="table" >
                    <thead>
                        <tr>
                            <td><p class="title">Code</p></td>
                            <td><p class="title">Name</p></td>
                            <td><p class="title">Linked To</p></td>
                            <td><p class="title">Action</p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="office in officeList.data">
                            <td>{{office.code}}</td>
                            <td>{{office.name}}</td>
                            <td>{{office.parent.name}}</td>
                            <td>
                                <b-button v-b-modal.my-modal @click="show(office,office.parent.level)">
                                    <i class="far fa-edit"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="lead float-left text-right" style="color:white">Showing Records {{officeList.from}} - {{officeList.to}} of {{totalRecords}} </p>
                <p class="lead float-right text-right" style="color:white">Total Records: {{totalRecords}} </p>
                <div class="clearfix"></div>
                <paginator :dataset="officeList" @updated="fetch"></paginator>
                <modal-office :info="singleOfficeInfo" :list_level="this.list_level"></modal-office>
                <loading :is-full-page="true" :active.sync="isLoading" ></loading>
            </div>
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
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default{
        props:['offices','level'],
        components:{
            Loading
        },
        data(){
           return { 
                "officeList":[],
                "singleOfficeInfo":[],
                "toOffice":"/edit/office/",
                'hasRecords': false,
                "isLoading":false,
                "list_level":"",
                'query':""
                // modalShow:false
           }
        },
        methods:{
            createOfficeLink(){
                return '/create/office/'+this.level
            },
            fetchOfficeLink(){
                return '/office/list/'+this.level
            },
            toUpdateOfficeLink(office_code){
                return this.toOffice + office_code
            },
            officeName(string) 
            {
                return string.charAt(0).toUpperCase() + string.slice(1).replace(/_/,' ');
            },
            show(office,list_level){
                this.list_level = list_level
                this.singleOfficeInfo = office
            },
            checkIfHasRecords(){
                this.hasRecords = false
                if (this.viewableRecords > 0){
                    this.hasRecords = true
                }
                
            },
            url(page=1){
                return `/office/list/`+this.level+`?page=`+page
            }
        },
        created(){  
            axios.get(this.fetchOfficeLink()).then(res => {
                console.log(res.data)
                this.officeList = res.data
            })

        },
        computed:{
            totalRecords(){
                return numeral(this.officeList.total).format('0,0')
            },
            viewableRecords(){
                return Object.keys(this.officeList.data).length
            }
        }

    }
</script>