<template>
	<div class="group-wrapper">
			<div class="card pb-4">
				<nav aria-label="breadcrumb">
		          <ol class="breadcrumb">
		            <li class="breadcrumb-item"><a :href="toOffice()">Office List</a></li>
		            <li class="breadcrumb-item active" aria-current="page">Edit Office</li>
		          </ol>
		        </nav>
				<h4 class="h4 ml-3 mt-4">Change Office</h4>
				<form @submit.prevent="submit">
					<div class="form-group col-md-6 mt-4">
			  			<label>Assign To:</label>
			  			<v2-select @officeSelected="assignOffice" :list_level="list_level" :default_value="fields.parent_id" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
			  			<div class="invalid-feedback" v-if="officeHasError">
	                        {{ errors.office_id[0]}}
	                    </div>
			  		</div>
					<div class="form-group col-md-6">
			  			<label for="code">Code</label>
						<div class="input-group mb-3">
						  <input type="text" class="form-control" id="code" aria-describedby="basic-addon3"
						  v-model="fields.code" v-bind:class="codeHasError ? 'is-invalid' : ''" :readonly="fields.code_readonly">
						  <div class="invalid-feedback" v-if="codeHasError">
		                        {{ errors.code[0]}}
		                    </div>
						</div>
					</div>

				  	<div class="form-group col-md-6">
				  		<label for="cluster_code">Name:</label>
				  		<input type="text" v-model="fields.name" id="name" class="form-control" v-bind:class="nameHasError ? 'is-invalid' : ''" :readonly="fields.name_readonly">
				  		<div class="invalid-feedback" v-if="nameHasError">
                            {{ errors.name[0]}}
                        </div>
				  	</div>

					<div class="form-group col-md-6">
				  		<label>Notes</label>
				  		<textarea class="form-control"></textarea>
				  	</div>
				  	<button type="submit" class="ml-3 btn btn-primary">Submit</button>
				  	
			  	</form>
			  	
		  	</div> 
	</div>
</template>
<script type="text/javascript">
	import SelectComponentV2 from './SelectComponentV2';
	import Swal from 'sweetalert2';
	export default{
		components: {
        	SelectComponentV2
   	 	},
   	 	props:['office','list_level'],
   	 	data(){
   	 		return{
   	 			fields:{
   	 				"id":"",
   	 				"office_id":"",
   	 				"level":"",
   	 				"code":"",
   	 				"branch_code":"######",
   	 				"name":"",
   	 				"code_readonly":true,
   	 				"name_readonly":true
   	 			},
   	 			errors:{}
   	 		}
   	 	},
   	 	created(){
   	 		this.populateOffice()
   	 		if (this.fields.level == "account_officer" || this.fields.level == "unit") {
   	 			this.fields.name_readonly = false
   	 		}
   	 	},
   	 	computed:{
   	 		hasErrors(){
	            return Object.keys(this.errors).length > 0;
	        },
   	 		officeHasError(){
	            return this.errors.hasOwnProperty('office_id')
	        },
	        nameHasError(){
	        	return this.errors.hasOwnProperty('name')
	        },
	        codeHasError(){
	        	return this.errors.hasOwnProperty('code')
	        },
	        officeInfo(){
	        	return JSON.parse(this.office)
	        }
   	 	},
   	 	methods:{
   	 		toOffice(){
   	 			return "/office/"+this.fields.level
   	 		},
   	 		assignOffice(value){
	            this.fields.office_id = value['id']
	        },
	        submit(){
	        	if (this.fields.level == "cluster") {
	        		this.fields.name = this.fields.code
	        	}

	        	axios.post('/edit/office', this.fields)
                .then(res=>{
                    this.isLoading = false
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
	        },
	        populateOffice(){

	        	var vm = this
	        	var office = this.officeInfo
	        	$.each(office,function(k,v){
                        vm.fields[k] = v
	            })
	           

	            this.fields.office_id = office.parent_id
	        }
   	 	}
	}
</script>