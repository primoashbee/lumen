@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
	<div class="card">
		<div class="card-header">
			<h3 class="h3">Insurance</h3>
		</div>
		<div class="card-body">
			<form>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group row">
							<div class="col-lg-12 form-group">
								<label class="d-inline-block col-form-label" for="application_number">Application Number:</label>
								<div class="ml-6 d-inline-block w8">
									<input type="text" id="application_number" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="packages">Packages</label>
							<select name="" id="packages" class="form-control">
								<option value="">Please Select Option</option>
								<option value="">Single - Parents (Mother / Father)</option>
								<option value="">Single - Siblings(3 Persons)</option>
								<option value="">Single - Single Parent Children(3 Children)</option>
								<option value="">Married - Spouse</option>
								<option value="">Married - Children(3)</option>
							</select>
						</div>

						<div class="row py-4">
							<h5 class="h5 col-lg-12">Mothers Information</h5>
							<div class="form-group col-lg-4">
								<label for="mother_firstname">First Name</label>
								<input type="text" class="form-control" id="mother_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="mother_middlename">Middle Name</label>
								<input type="text" class="form-control" id="mother_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="mother_lastname">Last Name</label>
								<input type="text" class="form-control" id="mother_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="mother_birthday">Birthday</label>
								 <input type="date" class="form-control" id="mother_birthday">
							</div>
						</div>

						<div class="row py-4">
							<h5 class="h5 col-lg-12">Fathers Information</h5>
							<div class="form-group col-lg-4">
								<label for="father_firstname">First Name</label>
								<input type="text" class="form-control" id="father_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="father_middlename">Middle Name</label>
								<input type="text" class="form-control" id="father_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="father_lastname">Last Name</label>
								<input type="text" class="form-control" id="father_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="father_birthday">Birthday</label>
								 <input type="date" class="form-control" id="father_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="sibling1">
		                                <input class="form-check-input cb-type" id="sibling1" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="sibling1">Sibling 1 Information</label>
		                            </label>
		                        </div>
							</div>	
							
							<div class="form-group col-lg-4">
								<label for="sibling1_firstname">First Name</label>
								<input type="text" class="form-control" id="sibling1_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling1_middlename">Middle Name</label>
								<input type="text" class="form-control" id="sibling1_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling1_lastname">Last Name</label>
								<input type="text" class="form-control" id="sibling1_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="sibling1_birthday">Birthday</label>
								 <input type="date" class="form-control" id="sibling1_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="sibling2">
		                                <input class="form-check-input cb-type" id="sibling2" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="sibling2">Sibling 2 Information</label>
		                            </label>
		                        </div>
							</div>	
							
							<div class="form-group col-lg-4">
								<label for="sibling2_firstname">First Name</label>
								<input type="text" class="form-control" id="sibling2_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling2_middlename">Middle Name</label>
								<input type="text" class="form-control" id="sibling2_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling2_lastname">Last Name</label>
								<input type="text" class="form-control" id="sibling2_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="sibling2_birthday">Birthday</label>
								 <input type="date" class="form-control" id="sibling2_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="sibling3">
		                                <input class="form-check-input cb-type" id="sibling3" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="sibling3">Sibling 3 Information</label>
		                            </label>
		                        </div>
							</div>	
							
							<div class="form-group col-lg-4">
								<label for="sibling3_firstname">First Name</label>
								<input type="text" class="form-control" id="sibling3_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling3_middlename">Middle Name</label>
								<input type="text" class="form-control" id="sibling3_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="sibling3_lastname">Last Name</label>
								<input type="text" class="form-control" id="sibling3_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="sibling3_birthday">Birthday</label>
								 <input type="date" class="form-control" id="sibling3_birthday">
							</div>
						</div>

						<div class="row py-4">
							<h5 class="h5 col-lg-12">Spouse Information</h5>
							<div class="form-group col-lg-4">
								<label for="spouse_firstname">First Name</label>
								<input type="text" class="form-control" id="spouse_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="spouse_middlename">Middle Name</label>
								<input type="text" class="form-control" id="spouse_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="spouse_lastname">Last Name</label>
								<input type="text" class="form-control" id="spouse_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="spouse_birthday">Birthday</label>
								 <input type="date" class="form-control" id="mother_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="child1">
		                                <input class="form-check-input cb-type" id="child1" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="child1">Child 1 Information</label>
		                            </label>
		                        </div>
							</div>	
							
							<div class="form-group col-lg-4">
								<label for="child1_firstname">First Name</label>
								<input type="text" class="form-control" id="child1_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="child1_middlename">Middle Name</label>
								<input type="text" class="form-control" id="child1_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="child1_lastname">Last Name</label>
								<input type="text" class="form-control" id="child1_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="child1_birthday">Birthday</label>
								 <input type="date" class="form-control" id="child1_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="child2">
		                                <input class="form-check-input cb-type" id="child2" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="child2">Child 2 Information</label>
		                            </label>
		                        </div>
							</div>		
							
							<div class="form-group col-lg-4">
								<label for="child2_firstname">First Name</label>
								<input type="text" class="form-control" id="child2_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="child2_middlename">Middle Name</label>
								<input type="text" class="form-control" id="child2_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="child2_lastname">Last Name</label>
								<input type="text" class="form-control" id="child2_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="child2_birthday">Birthday</label>
								 <input type="date" class="form-control" id="child1_birthday">
							</div>
						</div>

						<div class="row py-4">
							<div class="col-lg-12 pb-4">
								<div class="form-check p0">
		                            <label class="form-check-label" for="child3">
		                                <input class="form-check-input cb-type" id="child3" type="checkbox">
		                                <span class="form-check-sign">
		                                <span class="check"></span>
		                                </span>
		                                <label class="t-white text-xl" for="child1">Child 3 Information</label>
		                            </label>
		                        </div>
							</div>	
							
							<div class="form-group col-lg-4">
								<label for="child3_firstname">First Name</label>
								<input type="text" class="form-control" id="child3_firstname">
							</div>
							<div class="form-group col-lg-4">
								<label for="child3_middlename">Middle Name</label>
								<input type="text" class="form-control" id="child3_middlename">
							</div>
							<div class="form-group col-lg-4">
								<label for="child3_lastname">Last Name</label>
								<input type="text" class="form-control" id="child3_lastname">
							</div>
							<div class="form-group col-lg-4">
								 <label for="child3_birthday">Birthday</label>
								 <input type="date" class="form-control" id="child3_birthday">
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>									
</div>

@endsection