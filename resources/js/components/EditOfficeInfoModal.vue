<template>
	<div>
	  <div>
	    <b-modal id="my-modal" size="lg" hide-footer modal-title="Change Office" title="Edit Office" :header-bg-variant="background" :body-bg-variant="background">
	    	<form @submit.prevent="submit">
					<div class="form-group mt-4">
			  			<label>Assign To:</label>
			  			<v2-select @officeSelected="assignOffice" :list_level="list_level" :default_value="fields.parent_id" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
			  			<div class="invalid-feedback" v-if="officeHasError">
	                        {{ errors.office_id[0]}}
	                    </div>
			  		</div>
					<div class="form-group">
			  			<label for="code">Code</label>
						<div class="input-group mb-3">
						  <input type="text" class="form-control" id="code" aria-describedby="basic-addon3"
						  v-model="info.code" v-bind:class="codeHasError ? 'is-invalid' : ''" :readonly="fields.code_readonly">
						  <div class="invalid-feedback" v-if="codeHasError">
		                        {{ errors.code[0]}}
		                    </div>
						</div>
					</div>

				  	<div class="form-group">
				  		<label for="cluster_code">Name:</label>
				  		<input type="text" v-model="fields.name" id="name" class="form-control" v-bind:class="nameHasError ? 'is-invalid' : ''" :readonly="fields.name_readonly">
				  		<div class="invalid-feedback" v-if="nameHasError">
                            {{ errors.name[0]}}
                        </div>
				  	</div>

					<div class="form-group">
				  		<label>Notes</label>
				  		<textarea class="form-control"></textarea>
				  	</div>
				  	<button type="submit" class="btn btn-primary">Submit</button>
				  	
			  	</form>
	    </b-modal>
	  </div>
	</div>
</template>
<style type="text/css">
	@import "~vue-multiselect/dist/vue-multiselect.min.css";
    .modal-body .form-group label,.modal-body .form-group .form-control,.modal-title,.modal .multiselect__single,.close{
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
<script type="text/javascript">
	
	export default{
		props:['info',"list_level"],
		data(){
			return{
				fields:{
					"id":"",
   	 				"office_id":"",
   	 				"parent_id":"",
   	 				"level":"",
   	 				"code":"",
   	 				"branch_code":"######",
   	 				"name":"",
   	 				"code_readonly":true,
   	 				"name_readonly":true
				},
				"officeInfo":[],
				"variants": ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'light', 'dark'],
				"background":'dark',
				"text_color":"light",
				
				errors:{}
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
	        }
   	 	},
		created(){
			this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
		      if (bvEvent.type == "show") {
		      	this.officeInfo = this.info
		      	var vm = this
	        	var office = this.officeInfo
	        	 this.fields.office_id = office.parent_id
	        	$.each(office,function(k,v){
                        vm.fields[k] = v
	            })
	           
	            
		      }
		      if (this.fields.level == "account_officer" || this.fields.level == "unit") {
	   	 			this.fields.name_readonly = false
	   	 		}
		    })
		},
		methods:{
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
	        }
		}
	}
</script>