<template>
	<div class="row">
        <div class="col-lg-6">
            <label for="" style="color:white" class="lead mr-2">Filter:</label>
            <v2-select @officeSelected="assignOffice" class="d-inline-block" style="width:500px" v-model="office_id"></v2-select>
            <!-- <button type="button" class="btn btn-primary" @click="filter">Add New</button> -->
        </div>
        <div class="col-lg-6 float-right d-flex">
            <label for="" style="color:white" class="lead mr-2">Search:</label>
            <input type="text" id="search_client" class="form-control border-light pb-2" v-model="query" v-debounce:300ms="inputSearch"/>
        </div> 
        <div class="table-responsive">
        	<div class="w-100 px-3 mt-6">
	            <table class="table">
	                <thead>
	                    <tr>
	                        <td><p class="title">Client ID</p></td>
	                        <td><p class="title">Name</p></td>
	                        <td><p class="title">Linked To</p></td>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr>
	                        <td><a href="">A10000</a></td>
	                        <td>Nelson Tan</td>
	                        <td>Angeles</td>
	                    </tr>
	                </tbody>
	            </table>
	           <!--  <p class="lead float-left text-right" style="color:white">Showing Records {{lists.from}} - {{lists.to}} of {{totalRecords}} </p>
	            <p class="lead float-right text-right" style="color:white">Total Records: {{totalRecords}} </p>
	            <div class="clearfix"></div>
	            <paginator :dataset="lists" @updated="fetch"></paginator> -->
	        </div>
        </div>
        <loading :is-full-page="true" :active.sync="isLoading" ></loading>
    </div>	
</template>
<script type="text/javascript">
	import SelectComponentV2 from './SelectComponentV2';
	import Paginator from './PaginatorComponent';
	import vueDebounce from 'vue-debounce'
	import Loading from 'vue-loading-overlay';
	export default{
		components:{
	        Loading
	    },
		data(){
			return {
				query:"",
				lists:[],
				office_id:"",
				hasRecords: false,
            	isLoading:false
			}
		},
		methods:{
			inputSearch(){
	            
	        },
	        assignOffice(value){
            this.office_id = value['id']
	        }
		}
	}
</script>