@extends('layouts.user')
@section('content')
<div class="content pl-32 pl-64 pr-8 mt-4" id="content-full">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  

    <form action="{{url()->current()}}" method="post" class="row">
        @csrf
       <div class="col-md-9">
         <div class="card">
               <div class="card-header">
                 <h3 class="h3 ml-4">Profile</h3>
               </div>
               <div class="card-body">
                    <create-client-form></create-client-form>
               </div>
         </div>
       </div>
       <div class="col-md-3">
           <div class="card">
               <div class="card-header">
                   <h4 class="text-center h4">Attachment</h4>
               </div>

               <div class="card-body">
                <h3 class="px-3">Basic Information</h3>
                <div class="row px-3">
                  <div class="form-group col-md-6 col-lg-3">
                    <label for="client_id">Linked To</label>
                    <v2-select></v2-select>
                  </div>
                  <div class="form-group col-md-3 col-lg-3">
                    <label for="firstname">First Name</label>
                    <input value="{{ old('firstname') }}" type="text" id="firstname" name="firstname" class="form-control" z>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="middlename">Middle name</label>
                    <input value="{{ old('middlename') }}" type="text" id="middlename" name="middlename" class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="lastname">Last name</label>
                    <input value="{{ old('lastname') }}" id="lastname" type="text" name="lastname" class="form-control" z>
                  </div>
                </div>
                <div class="row px-3">
                      <div class="form-group col-md-2">
                          <label for="suffix">Suffix </label>
                          <input value="{{ old('suffix') }}" type="text" name="suffix" id="suffix" class="form-control" >
                      </div>

                      <div class="form-group col-md-3">
                          <label for="nickname">Nickname</label>
                          <input value="{{ old('nickname') }}" type="text" name="nickname" id="nickname" class="form-control">
                      </div>

                      <div class="form-group px-3 col-md-3">
                          <label for="gender">Gender</label>
                          <div class="select">
                            <select name="gender" id="gender">
                              <option selected disabled>Choose an option</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                      </div>

                      <div class="form-group col-md-4 px-3">
                          <label for="civil_status">Marital Status</label>
                          <div class="select">
                            <select name="civil_status" id="civil_status">
                              <option selected disabled>Choose an option</option>
                              <option value="Single">Single</option>
                              <option value="Married">Married</option>
                              <option value="Divored">Divorced</option>
                              <option value="Widowed">Widowed</option>
                            </select>
                          </div>
                      </div>

                </div>
                <div class="row px-3">
                      <div class="form-group col-md-6">
                          <label id="fb_account">Facebook Account</label>
                          <input value="{{ old('fb_account') }}" type="text" name="fb_account" id="fb_account" class="form-control" z>
                      </div>
                      <div class="form-group col-md-6">
                          <label id="contact_number">Phone Number</label>
                          <input value="{{ old('contact_number') }}" type="text" placeholder="09XXXXXXXXX" name="contact_number" id="contact_number" class="form-control" z>
                      </div>
              </div>
              <div class="row px-3">

                      <div class="form-group col-md-3 px-3">
                          <label for="birthday">Date Of Birth</label>
                          <date-picker name="birthday" id="birthday" value=""></date-picker>
                      </div>

                      <div class="form-group col-md-4 px-3">
                          <label for="birthplace">Birthplace</label>
                          <input value="{{ old('birthplace') }}" id="birthplace" type="text" class="form-control" name="birthplace" z autocomplete="birthplace">
                      </div>


                      <div class="form-group col-md-5 px-3">
                          <label for="education">Educational Attainment</label>
                          <div class="select">
                            <select name="education" id="education">
                              <option selected disabled>Choose an option</option>
                              <option value="College">College</option>
                              <option value="Vocational">Vocational</option>
                              <option value="High School">High School</option>
                              <option value="Elementary">Elementary</option>
                            </select>
                          </div>
                      </div>
              </div>
              <h3 class="px-3 my-4 h3">Address Information</h3>
              <div class="row px-3">
                      <div class="form-group px-3 col-md-9">
                          <label for="street_address">Street Address</label>
                          <input value="{{ old('street_address') }}" type="text" name="street_address" id="street_address" class="form-control" z>
                      </div>
                      <div class="form-group col-md-3 px-2">
                          <label for="barangay_address">Barangay</label>
                          <input value="{{ old('barangay_address') }}" type="text" name="barangay_address" id="barangay_address" class="form-control" z>
                      </div>
              </div>
              <div class="row px-3">
                      <div class="form-group col-md-4">
                          <label for="city_address">City</label>
                          <input value="{{ old('city_address') }}" type="text" name="city_address" id="city_address" class="form-control" z>
                      </div>
                      <div class="form-group col-md-4">
                          <label for="province_address">Province</label>
                          <input value="{{old('province_address')}}" type="text" name="province_address" id="province_address" class="form-control" z>
                      </div>
                      <div class="form-group col-md-4 px-2">
                          <label for="zipcode">Postal/Zip code</label>
                          <input value="{{old('zipcode')}}" type="text" name="zipcode" id="zipcode" class="form-control" z>
                      </div>
              </div>
              <h3 class="px-3 my-3 h3">Family Information</h3>	
              <div class="row px-3">
                      <div class="form-group col-md-12">
                          <label for="business_address">Full Business Address</label>
                          <input value="{{ old('business_address') }}" type="text" name="business_address" id="business_address" class="form-control" z>
                      </div>
                  </div>

                  <div class="row px-3">
                      <div class="form-group px-3 col-md-3">
                          <label for="number_of_dependents">No. of dependents</label>
                          <input value="{{ old('number_of_dependents') }}" type="number" name="number_of_dependents" id="number_of_dependents" class="form-control" z>
                      </div>
                      <div class="form-group px-3 col-md-3">
                          <label for="household_size">Household Size</label>
                          <input type="number" value="{{ old('household_size') }}" name="household_size" id="household_size" class="form-control" z>
                      </div>
                      <div class="form-group px-3 col-md-3">
                          <label for="years_of_stay_on_house">Years of Residency</label>
                          <input value="{{ old('years_of_stay_on_house') }}" type="number" name="years_of_stay_on_house" id="years_of_stay_on_house" class="form-control" z>
                      </div>

                      <div class="form-group px-3 col-md-3 col-md-offset-2">
                          <label for="house_type">House Type</label>
                          <select name="house_type" id="house_type" class="form-control">
                              <option value="">Choose an option</option>
                              <option value="Owned">Owned</option>
                              <option value="Rented">Rented</option>
                          </select>
                      </div>

                  </div>


                  <div class="row px-3">
                      <div class="form-group col-md-6">
                          <label for="spouse_name">Spouse Name</label>
                          <input value="{{ old('spouse_name') }}" type="text" name="spouse_name" class="form-control" id="spouse_name" z>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="spouse_contact_number">Spouse Contact Number</label>
                          <input value="{{ old('spouse_contact_number') }}" type="text" name="spouse_contact_number" class="form-control" id="spouse_contact_number" placeholder="09XXXXXXXXX" z>
                      </div>
                      <div class="form-group col-md-4 col-md-offset-8">
                          <label for="spouse_birthday">Spouse Birthday</label>
                          <input value="{{ old('spouse_birthday') }}" type="date" name="spouse_birthday" id="spouse_birthday" class="form-control" z>
                      </div>
                  </div>

              <h3 class="px-3 my-4 h3">Statutories</h3>

                  <div class="row px-3">
                      <div class="form-group col-md-4">
                          <label>TIN</label>
                          <input value="{{ old('tin') }}" type="text" name="tin" id="tin" class="form-control">
                      </div>
                      <div class="form-group col-md-4">
                          <label>SSS</label>
                          <input value="{{ old('sss') }}" type="text" name="tin" id="sss" class="form-control">
                      </div>
                      <div class="form-group col-md-4">
                          <label>UMID</label>
                          <input value="{{ old('umid') }}" type="text" name="umid" id="umid" class="form-control">
                      </div>
                      <div class="form-group col-md-6 col-md-offset-6">
                          <label>Mothers Maiden Name</label>
                          <input value="{{ old('mother_maiden_name') }}" type="text" name="mother_maiden_name" id="mother_maiden_name" class="form-control" z>
                      </div>
                  </div>

              <h3 class="px-3 my-4 h3">Employment Income</h3>

                  <div class="row px-3">
                      <h3 class="col-md-6 px-3 my-2 h3">Personal</h3>
                      <h3 class="col-md-6 h3">Spouse</h3>
                      <div class="form-group col-md-3">
                          <div class="p0 form-check">
                              <label class="form-check-label" for="self_employed">
                                <input class="form-check-input cb-type" id="self_employed" type="checkbox" name="is_self_employed" value="">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="self_employed">Self-Employed</label>
                              </label>
                          </div>
                          <div class="hi form-group p0 my-2" data-attribute="self_employed">
                              <label for="sevice_type">Service Type</label>
                              <div class="select">
                                <select name="sevice_type" id="sevice_type">
                                  <option selected="selected" disabled="disabled">Choose an option</option> 
                                  <option value="Agriculture"> Agriculture </option>
                                  <option value="Trading/Merchandising"> Trading/Merchandising </option>
                                  <option value="Manufacturing"> Manufacturing </option>
                                  <option value="Service"> Service </option>
                                  <option value="Others"> Others </option>
                                </select>
                              </div>
                          </div>
                          <div class="hi form-group p0 my-2" data-attribute="self_employed">
                              <label for="service_type_gross_income">Monthly Income</label>
                              <input type="text" id="service_type_gross_income" name="service_type_gross_income" class="form-control" value="{{ old('service_type_gross_income') }}">
                          </div>
                      </div>

                      <div class="form-group col-md-3">
                          <div class="p0 form-check">
                              <label class="form-check-label" for="is_employed">
                                <input class="form-check-input cb-type" id="is_employed" type="checkbox" name="is_employed">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="is_employed">Working on Company</label>
                              </label>
                          </div>
                          <div class="hi my-2" data-attribute="is_employed">
                              <div class="row">
                                  <div class="form-group w-100">
                                      <label for="employed_position">Position</label>
                                      <input value="{{ old('employed_position') }}" type="text" name="employed_position" class="form-control" id="employed_position">
                                  </div>
                                  <div class="form-group w-100">
                                      <label for="employed_company_name">Company Name</label>
                                      <input value="{{ old('employed_company_name') }}" type="text" name="employed_company_name" class="form-control" id="employed_company_name">
                                  </div>
                                  <div class="form-group w-100">
                                      <label for="employed_monthly_gross_income">Monthly Gross income</label>
                                      <input value="{{ old('employed_monthly_gross_income') }}" type="text" name="employed_monthly_gross_income" class="form-control" id="employed_monthly_gross_income">
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="form-group col-md-3">
                          <div class="p0 form-check">
                              <label class="form-check-label" for="spouse_is_self_employed">
                                <input class="form-check-input cb-type" id="spouse_is_self_employed" type="checkbox" name="spouse_is_self_employed" value="">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="spouse_is_self_employed">Spouse Self-Employed</label>
                              </label>
                          </div>
                          <div class="hi form-group col-md-12 p0 my-2" data-attribute="spouse_is_self_employed">
                              <label for="spouse_service_type">Spouse Service Type</label>
                               <select name="spouse_service_type" id="spouse_service_type" class="form-control">
                                   <option selected="selected" disabled="disabled">Choose an option</option> 
                                   <option value="Agriculture"> Agriculture </option>
                                   <option value="Trading/Merchandising"> Trading/Merchandising </option>
                                   <option value="Manufacturing"> Manufacturing </option>
                                   <option value="Service"> Service </option>
                                   <option value="Others"> Others </option>
                               </select>
                          </div>
                          <div class="hi form-group p0 my-2" data-attribute="spouse_is_self_employed" >
                              <label for="spouse_service_type_gross_income">Monthly Income</label> 
                              <input type="text" id="spouse_service_type_gross_income" name="spouse_service_type_gross_income" value="{{ old('spouse_service_type_gross_income')}}" class="form-control">
                           </div>
                      </div>

                      <div class="form-group col-md-3">
                          <div class="p0 form-check">
                              <label class="form-check-label" for="spouse_is_employed">
                                <input class="form-check-input cb-type" id="spouse_is_employed" type="checkbox" name="spouse_is_employed" value="">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="spouse_is_employed">Spouse Working on Company</label>
                              </label>
                          </div>
                          <div class="hi my-2" data-attribute="spouse_is_employed">
                              <div class="row">
                                  <div class="form-group w-100">
                                      <label for="spouse_position">Position</label>
                                      <input value="{{ old('spouse_employed_position') }}" type="text" name="spouse_position" class="form-control" id="spouse_position">
                                  </div>
                                  <div class="form-group w-100">
                                      <label for="spouse_company_name">Spouse Company Name</label>
                                      <input value="{{ old('spouse_employed_company_name') }}" type="text" name="spouse_employed_company_name" class="form-control" id="spouse_employed_company_name">
                                  </div>
                                  <div class="form-group w-100">
                                      <label for="spouse_employed_monthly_gross_income">Spouse Monthly Gross income</label>
                                      <input value="{{ old('spouse_employed_monthly_gross_income') }}" type="text" name="spouse_employed_monthly_gross_income" class="form-control" id="spouse_employed_monthly_gross_income">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

              <h3 class="px-3 my-4">Other Income</h3>	
                  <div class="row px-3">
                      <div class="form-group col-md-3">
                          <div class="form-check p0">
                              <label class="form-check-label" for="has_remittance">
                                <input class="form-check-input cb-type" id="has_remittance" type="checkbox" name="has_remittance" value="">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="has_remittance">Remittance</label>
                              </label>
                          </div>
                          <div class="hi form-group col-md-12 p0 my-2" data-attribute="has_remittance">
                              <label for="remittance_amount">Remittance Amount</label>
                              <input value="{{old('remittance_amount')}}" type="number" name="remittance_amount" class="form-control" id="remittance_amount">
                          </div>
                      </div>

                      <div class="form-group col-md-3">
                          <div class="p0 form-check">
                              <label class="form-check-label" for="has_pension">
                                <input class="form-check-input cb-type" id="has_pension" type="checkbox" name="has_pension">
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                                <label for="has_pension">Pension</label>
                              </label>
                          </div>
                          <div class="hi form-group col-md-12 p0 my-2" data-attribute="has_pension">
                              <label for="pension_amount">Pension Amoount</label>
                              <input value="{{old('pension_amount')}}" type="number" name="pension_amount" class="form-control" id="pension_amount">
                          </div>
                      </div>
                  </div>

                  <div class="row px-3 my-3">
                      <div class="form-group col-md-4 col-md-offset-8">
                          <label class="">Total household income</label>
                          <input value="{{ old('total_household_income') }}" type="text" class="form-control" name="total_household_income">
                      </div>
                  </div>

              <h4 class="my-2 px-3 h3">Notes</h4>
                  <div class="row px-3">
                      <div class="form-group col-md-12">
                          <textarea value="{{ old('notes') }}" rows="3" cols="40" name="notes" class="form-control"></textarea>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary mx-3">Submit</button>
                  <button class="btn btn-primary">Cancel</button>
          
                <img src="{{ asset('assets/img/default.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
                <img src="{{ asset('assets/img/signature.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
               </div>
           </div>
       </div> 
     </form>
   </div>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', function() {
        document.getElementById('gender').value = '{{old('gender')}}'
        document.getElementById('civil_status').value = '{{old('civil_status')}}'
        document.getElementById('education').value = '{{old('education')}}'
        document.getElementById('house_type').value = '{{old('house_type')}}'
        document.getElementById('house_type').value = '{{old('house_type')}}'
    })    
</script>
@endsection