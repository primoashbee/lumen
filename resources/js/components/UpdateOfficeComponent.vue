<template>
	<div class="group-wrapper">
			<div class="card pb-4">
				<h4 class="h4 ml-3 mt-4">Edit Office</h4>
				<form @submit.prevent="submit">
					<div class="form-group col-md-6 mt-4">
			  			<label>Assign To:</label>
			  			<v2-select @officeSelected="assignOffice" :list_level="list_level" :default_value="fields.parent_id" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
			  			<div class="invalid-feedback" v-if="officeHasError">
	                        {{ errors.office_id[0]}}
	                    </div>
			  		</div>

			  		<div class="form-group col-md-6">
				  		<label>Code:</label>
				  		<input type="text" v-model="fields.code" id="code" class="form-control" v-bind:class="codeHasError ? 'is-invalid' : ''">
				  		<div class="invalid-feedback" v-if="codeHasError">
	                        {{ errors.code[0]}}
	                    </div>
				  	</div>

				  	<div class="form-group col-md-6">
				  		<label for="cluster_code">Name:</label>
				  		<input type="text" v-model="fields.name" id="name" class="form-control" v-bind:class="nameHasError ? 'is-invalid' : ''" :readonly="fields.readonly">
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
   	 				"name":"",
   	 				"readonly":false
   	 			},
   	 			errors:{}
   	 		}
   	 	},
   	 	created(){

   	 		this.populateOffice()	
   	 		if(this.fields.level == "cluster"){
   	 			this.fields.readonly = true
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
   	 		assignOffice(value){
	            if (this.level == "cluster") {
   	 				this.fields.code = value['name'] + "-"
   	 			}
	            this.fields.office_id = value['id']
	        },

	        submit(){
	        	if(this.fields.level == "cluster"){
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