@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
	<div class="card col-lg-9">
		<div class="pl-0 pt-3 card-header">
			<h3 class="h3">User Information</h3>		
		</div>
		<form class="row user-form">
			<div class="card-body">
				<div class="row">
					<div class="col-lg-4 form-group">
						<label for="firstname">First Name</label>
						<input type="text" name="firstname" id="firstname" class="form-control">
					</div>
					<div class="col-lg-4 form-group">
						<label for="middlename">Middle Name</label>
						<input type="text" name="middlename" id="middlename" class="form-control">
					</div>
					<div class="col-lg-4 form-group">
						<label for="lastname">Last Name</label>
						<input type="text" name="lastname" id="lastname" class="form-control">
					</div>
				</div>
				<div class="row mb-5">
					<div class="col-lg-4 form-group">
						<label for="birthday">Birthday</label>
						<input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday') }}" required autocomplete="birthday">
					</div>
					<div class="form-group col-lg-4 mr-5">
	                   <label for="gender">Gender</label>
	                   <div class="select">
	                     <select name="gender" id="gender">
	                       <option selected disabled>Choose an option</option>
	                       <option value="1">Male</option>
	                       <option value="2">Female</option>
	                     </select>
	                   </div>
	               	</div>   
               	</div>	
               	
               	<div class="row">
               		
               		<div class="col-lg-6">
               			<h3 class="h3 mb-2">Credentials</h3>
		               	<div class="col-lg-12 p0 form-group">
							<label for="email">Email</label>
							<input type="text" name="email" id="email" class="form-control">
						</div>
					
						<div class="col-lg-12 p0 form-group">
							<label for="password">Password</label>
							<input type="text" name="password" id="password" class="form-control">
						</div>
					
						<div class="col-lg-12 p0 form-group">
							<label for="confirm_password">Confirm Password</label>
							<input type="text" name="confirm_password" id="confirm_password" class="form-control">
						</div>
					</div>
					
					<div class="col-lg-6">
						<h3 class="h3 mb-2">User Group</h3>
						<div class="form-group col-lg-12 p0">
							<label for="role">User Role</label>
							<input type="text" name="role" id="role" class="form-control">
						</div>
						<div class="form-group col-lg-12 p0">
							<org-structure ></org-structure>   
						</div>
					</div>

					<div class="form-group col-lg-12 pb-4 mt-4">
						<label for="notes">Notes</label>
						<textarea id="notes" name="notes" class="form-control"></textarea>
					</div>
					<button type="submit" class="btn btn-primary mx-3">Submit</button>
                    <button class="btn btn-primary">Cancel</button>
				</div>	
			</div>
		</form>	
	</div>
</div>
@endsection
@section('script')
    <script>

        $(function(){
            $('#birthday').datepicker({
                format: 'mm/dd/yyyy',
                todayBtn: true
            });
        })

    </script>
@endsection