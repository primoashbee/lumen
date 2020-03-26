@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
	<div class="group-wrapper">
			<div class="card pb-4">
				<h4 class="h4 ml-3 mt-4">Create Penalty</h4>
				<form>
				  	<div class="form-group col-md-6">
				  		<label for="cluster_code">Penalty Name</label>
				  		<input type="text" class="form-control">
				  	</div>

				  	<div class="form-group col-md-6">
				  		<label>Minimum Amount</label>
				  		<input type="number" class="form-control">
				  	</div>

				  	<div class="form-group col-md-6">
				  		<label>Percentage</label>
				  		<input type="number" class="form-control">
				  	</div>
				  	<button type="submit" class="ml-3 btn btn-primary">Submit</button>
			  	</form>
			  	
		  	</div> 
	</div>
</div>

@endsection