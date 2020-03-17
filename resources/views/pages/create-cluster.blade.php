@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
	<div class="card col-md-8 col-lg-8 cluster-wrapper">

		<form class="row">
			<div class="col-md-12 pb-4">
				<h3 class="h3 mb-3 pt-3">Cluster Information</h3>
				<div class="col-md-8 mb-3">
					<org-structure ></org-structure>
				</div>
				<div class="row">
					<div class="form-group col-lg-4 col-md-4">
						<label>Cluster ID</label>
						<input type="text" name="cluster_id" class="form-control">
					</div>
					<div class="form-group col-lg-4 col-md-4 px-3">
	               		<label for="meeting_day">Cluster President</label>
	               		<input type="text" name="cluster_president" class="form-controlp">
	               </div>
					<div class="form-group col-lg-4 col-md-4 px-3">
	                   <label for="credit_officer">Credit Officer</label>
	                   <div class="select">
	                     <select name="credit_officer" id="credit_officer">
	                       <option selected disabled>Choose an option</option>
	                       <option value="">Nelson Tan</option>
	                       <option value="">Ashbee Morgado</option>
	                     </select>
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