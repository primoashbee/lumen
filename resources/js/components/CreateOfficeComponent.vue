<template>
	<div class="group-wrapper">
			<div class="card pb-4">
				<h4 class="h4 ml-3 mt-4">Create Branch</h4>
				<form @submit.prevent="submit">
					<div class="form-group col-md-6 mt-4">
			  			<label>Assign To:</label>
			  			<v2-select @officeSelected="assignOffice" :list_level="this.list_level" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
			  			<div class="invalid-feedback" v-if="officeHasError">
	                        {{ errors.office_id[0]}}
	                    </div>
			  		</div>

			  		<div class="form-group col-md-6">
				  		<label>Code:</label>
				  		<input type="number" v-model="fields.code" class="form-control">
				  	</div>

				  	<div class="form-group col-md-6">
				  		<label for="cluster_code">Name</label>
				  		<input type="text" v-model="fields.name" class="form-control">
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
   	 	props:['list_level'],
   	 	data(){
   	 		return{
   	 			fields:{
   	 				'office_id':"",
   	 				'code':"",
   	 				'name':"",
   	 				"level":this.list_level
   	 			},
   	 			errors:{}
   	 		}
   	 	},
   	 	computed:{
   	 		hasErrors(){
	            return Object.keys(this.errors).length > 0;
	        },
   	 		officeHasError(){
	            return this.errors.hasOwnProperty('office_id')
	        }
   	 	},
   	 	methods:{
   	 		assignOffice(value){
	            this.fields.office_id = value['id']
	        },
	        submit(){
	        	 axios.post('/create/office', this.fields)
                .then(res=>{
                    this.isLoading = false
                    Swal.fire({
                        icon: 'success',
                        title: '<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">Success!</span>',
                        text: res.data.msg,
                        confirmButtonText: 'OK'
                    })
                    .then(res=>{
                        
                    })
                })
                .catch(error=>{
                    this.errors = error.response.data.errors || {}
                })
	        }
   	 	}
	}
</script>