<template>
<div>
      
    <div class="card">
		<div class="card-header">
			<h3 class="h3"><b><a :href="clientLink" style="text-decoration:none;color:white">{{name}}</a></b> - Insurance</h3>
		</div>
		<div class="card-body">
            <a :href="linkCreateDependent"><button class="btn btn-primary float-right">Create Dependents</button></a>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>
                            <p class="title">Application Number</p>
                        </td>
                        <td>
                            <p class="title">Unit of Plan</p>
                        </td>
                        <td>
                            <p class="title">Dependents</p>
                        </td>
                        <td>
                            <p class="title">Amount</p>
                        </td>
                        <td>
                            <p class="title">Status</p>
                        </td>
                        <td>
                            <p class="title">Action</p>
                        </td>
                    </tr>
                </thead>
                <tbody>
                     <tr v-for="item in client.dependents" :key="item.id">
                        <td>{{item.application_number}}</td>
                        <td>{{item.unit_of_plan}}</td>
                        <td>{{item.dependents}}</td>
                        <td>{{item.amount}}</td>
                        <td>
                            <toggle-button :disabled="disabled(item.id)" @change="changeStatus($event,item.application_number)" :value="isActive(item.id)" color="green"  :labels="true"/>
                        </td>
                        <td>
                            <div class="btn btn-light" @click="showModal(item.pivot_list)"><i class="fa fa-eye"></i></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<!-- Modal -->
    <div class="modal fade" id="dependents_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center"  style="color:black" >Application Number: <b>{{this.viewed_dependent_application_number}}</b> </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-condensed">
                    <thead>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Relationship</th>
                    </thead>
                    <tbody id="tbody" v-if="selected_pivot_list!=null" >
                        <tr v-for="item in selected_pivot_list" :key="item.id">
                            <td>{{item.name}}</td>
                            <td>{{item.age}}</td>
                            <td>{{item.relationship}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import Swal from 'sweetalert2';
import 'vue-loading-overlay/dist/vue-loading.css';
import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)
export default {
    components: {
        Loading
    },
    props:['data'],
    mounted(){
        this.client_id = this.client.client_id
        // if(this.client.active_dependent != nul)
    },
    data(){
        return {
            client_id:null,
            selected_pivot_list:null,
            active_dependent_application_number: null,
            viewed_dependent_application_number: null,
        }
    },
    methods:{
        isActive(dependent_id){
            if(this.client.active_dependent==null){
                return false;
            }
            if(dependent_id == this.client.active_dependent.id){
                return true
            }
            return false
        },
        changeStatus(event,application_number){
            
            
            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You can only have 1 active dependent. Activating this will deactive existing active dependent ",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#008000',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Active'
            // })
            // .then((result) => {
            // if (result.isConfirmed) {
            //     Swal.fire(
            //     'Activated!',
            //     'Dependents Activated ('+application_number+')',
            //     'success'
            //     )
            // }
            // })
            if(event.value){
                axios.get('/client/update/dependent?application_number='+application_number+'&type=activate')
                .then(res=>{
                    location.reload()
                })
            }else{
                axios.get('/client/update/dependent?application_number='+application_number+'&type=deactivate')
                .then(res=>{
                    location.reload()
                })
            }
        },
        showModal(pivot_list){
            this.selected_pivot_list = pivot_list
            this.viewed_dependent_application_number = pivot_list[0].application_number
            
            console.log(pivot_list);
            $('#dependents_modal').modal('show')
        },
        disabled(dependent_id){
            if(this.hasActive){
                if(this.client.active_dependent.id == dependent_id){
                    return false;
                }
                return true;
            }
            return false
        }
    },
    computed: {
        linkCreateDependent(){
            return '/client/'+this.client_id+'/create/dependents'
        },
        name(){
            return this.client.full_name;
        },
        client(){
            return JSON.parse(this.data)
        },
        hasActive(){
            return this.client.active_dependent != null
        },
        clientLink(){
			return '/client/'+this.client_id
		
        }

    }

}
</script>

<style>
    .swal2-title{
        color:black !important;
    }
</style>