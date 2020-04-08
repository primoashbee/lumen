 <template>
        <div class="row">
            <div class="col-lg-6 float-left d-flex">
                <label for="" style="color:white" class="lead mr-2">Search:</label>
                <input type="text" id="office_client" class="form-control border-light pb-2" />
            </div>
            <div class="col-lg-6 text-right">
                <a :href="createOfficeLink()" type="submit" class="btn btn-primary px-8">Create Office</a>
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
                        <tr v-for="office in officeList">
                            <td>{{office.code}}</td>
                            <td>{{office.name}}</td>
                            <td>{{office.parent.name}}</td>
                            <td>
                                <a :href="toUpdateOfficeLink(office.id)" class="actions">
                                   <i class="fas fa-1x fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="lead float-left text-right" style="color:white">Showing Records </p>
                <p class="lead float-right text-right" style="color:white">Total Records: </p>
                
                <!-- <paginator :dataset="lists" @updated="fetch"></paginator> -->
            </div>
        </div>

</template>

<script>
    export default{
        props:['offices','level'],
        data(){
           return { 
                officeList:[],
                toOffice:"/edit/office/"
           }
        },
        created(){
            this.officeList = JSON.parse(this.offices)
        },
        methods:{
            createOfficeLink(){
                return '/create/office/'+this.level
            },
            toUpdateOfficeLink(office_code){
                return this.toOffice + office_code
            }
        }
    }
</script>