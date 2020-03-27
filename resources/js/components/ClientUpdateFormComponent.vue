<template>
<div class="row">
<div class="col-md-9">
    <div class="card">
          <div class="card-header">
            <h3 class="h3 ml-3">Profile</h3>
          </div>
          <div class="card-body">
            <form @submit.prevent="submit">
                <h3 class="px-3">Basic Information</h3>
                <div class="row px-3">
                <div class="form-group col-md-6 col-lg-3">
                    <label for="client_id">Linked To</label>
                    <v2-select @officeSelected="assignOffice" :value="this.fields.office_id" v-bind:class="officeHasError ? 'is-invalid' : ''"></v2-select>
                    <div class="invalid-feedback" v-if="officeHasError">
                        {{ errors.office_id[0]}}
                    </div>
            
                </div>
                <div class="form-group col-md-3 col-lg-3">
                    <label for="firstname">First Name</label>
                    <input value="" type="text" id="firstname" v-model="fields.firstname" class="form-control"  v-bind:class="firstNameHasError ? 'is-invalid' : ''" z>
                    <div class="invalid-feedback" v-if="firstNameHasError">
                        {{ errors.firstname[0]}}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="middlename">Middle name</label>
                    <input value="" type="text" id="middlename" v-model="fields.middlename" class="form-control" v-bind:class="middleNameHasError ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-if="middleNameHasError">
                        {{ errors.middlename[0]}}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="lastname">Last name</label>
                    <input value="" id="lastname" type="text" v-model="fields.lastname" class="form-control" v-bind:class="lastNameHasError ? 'is-invalid' : ''" z>
                    <div class="invalid-feedback" v-if="lastNameHasError">
                        {{ errors.lastname[0]}}
                    </div>
                </div>
                </div>
                <div class="row px-3">
                    <div class="form-group col-md-2">
                        <label for="suffix">Suffix </label>
                        <input value="" type="text" v-model="fields.suffix" id="suffix" class="form-control" v-bind:class="suffixNameHasError ? 'is-invalid' : ''" >
                    </div>
            
                    <div class="form-group col-md-3">
                        <label for="nickname">Nickname</label>
                        <input value="" type="text" v-model="fields.nickname" id="nickname" class="form-control" v-bind:class="nickNameHasError ? 'is-invalid' : ''">
                    </div>
            
                    <div class="form-group px-3 col-md-3">
                        <label for="gender">Gender</label>
                        <div class="select" v-bind:class="genderHasError ? 'is-invalid' : ''">
                            <select v-model="fields.gender" id="gender" class="form-control" v-bind:class="genderHasError ? 'is-invalid' : ''">
                                <option selected disabled>Choose an option</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="invalid-feedback" v-if="genderHasError">
                            {{ errors.gender[0]}}
                        </div>        
                        
                    </div>
            
                    <div class="form-group col-md-4 px-3">
                        <label for="civil_status">Marital Status</label>
                        <div class="select" v-bind:class="civilStatusHasError ? 'is-invalid' : ''">
                            <select v-model="fields.civil_status" id="civil_status" class="form-control" v-bind:class="civilStatusHasError ? 'is-invalid' : ''">
                                <option selected disabled>Choose an option</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="invalid-feedback" v-if="civilStatusHasError">
                            {{ errors.civil_status[0]}}
                        </div> 
                    </div>
            
                </div>
                <div class="row px-3">
                    <div class="form-group col-md-6">
                        <label id="fb_account">Facebook Account</label>
                        <input value="" type="text" v-model="fields.fb_account" id="fb_account" class="form-control" v-bind:class="facebookHasError ? 'is-invalid' : ''" z>
            
                        <div class="invalid-feedback" v-if="facebookHasError">
                            {{ errors.facebook[0]}}
                        </div>    
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label id="contact_number">Phone Number</label>
                        <input value="" type="text" placeholder="09XXXXXXXXX" v-model="fields.contact_number" id="contact_number" class="form-control" v-bind:class="phoneHasError ? 'is-invalid' : ''" z>
                    
                        <div class="invalid-feedback" v-if="phoneHasError">
                            {{ errors.contact_number[0]}}
                        </div>   
                    </div> 
                </div>
                <div class="row px-3">
            
                    <div class="form-group col-md-3 px-3">
                        <label for="birthday">Date Of Birth</label>
                        <date-picker id="birthday" v-model="fields.birthday" @datePicked="getDate($event, 'birthday')" ></date-picker>
                    </div>
            
                    <div class="form-group col-md-4 px-3">
                        <label for="birthplace">Birthplace</label>
                        <input value="" id="birthplace" type="text" class="form-control" v-model="fields.birthplace" v-bind:class="birthplaceHasError ? 'is-invalid' : ''" z autocomplete="birthplace">
                        <div class="invalid-feedback" v-if="birthplaceHasError">
                            {{ errors.birthplace[0]}}
                        </div>  
                    </div>
            
            
                    <div class="form-group col-md-5 px-3">
                        <label for="education">Educational Attainment</label>
                        <div class="select" v-bind:class="educationHasError ? 'is-invalid' : ''">
                            <select v-model="fields.education" id="education" class="form-control" v-bind:class="educationHasError ? 'is-invalid' : ''">
                                <option selected disabled>Choose an option</option>
                                <option value="College">College</option>
                                <option value="Vocational">Vocational</option>
                                <option value="High School">High School</option>
                                <option value="Elementary">Elementary</option>
                            </select>
                        </div>
                        <div class="invalid-feedback" v-if="educationHasError">
                            {{ errors.education[0]}}
                        </div>  
                    </div>
                </div>
                <h3 class="px-3 my-4 h3">Address Information</h3>
                <div class="row px-3">
                    <div class="form-group px-3 col-md-9">
                        <label for="street_address">Street Address</label>
                        <input value="" type="text" v-model="fields.street_address" id="street_address" class="form-control" v-bind:class="streetHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="streetHasError">
                            {{ errors.street_address[0]}}
                        </div>          
                    </div>
                    <div class="form-group col-md-3 px-2">
                        <label for="barangay_address">Barangay</label>
                        <input value="" type="text" v-model="fields.barangay_address" id="barangay_address" class="form-control" v-bind:class="barangayHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="barangayHasError">
                            {{ errors.barangay_address[0]}}
                        </div>      
                    </div>
                </div>
                <div class="row px-3">
                    <div class="form-group col-md-4">
                        <label for="city_address">City</label>
                        <input value="" type="text" v-model="fields.city_address" id="city_address" class="form-control" v-bind:class="cityHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="cityHasError">
                            {{ errors.city_address[0]}}
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="province_address">Province</label>
                        <input value="" type="text" v-model="fields.province_address" id="province_address" class="form-control" v-bind:class="provinceNameHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="provinceNameHasError">
                            {{ errors.province_address[0]}}
                        </div>
                    </div>
            
            
                    <div class="form-group col-md-4 px-2">
                        <label for="zipcode">Postal/Zip code</label>
                        <input value="" type="text" v-model="fields.zipcode" id="zipcode" class="form-control" v-bind:class="zipCodeHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="zipCodeHasError">
                            {{ errors.zipcode[0]}}
                        </div>
                    </div>
                </div>
                <h3 class="px-3 my-3 h3">Family Information</h3>	
                <div class="row px-3">
                    <div class="form-group col-md-12">
                        <label for="business_address">Full Business Address</label>
                        <input value="" type="text" v-model="fields.business_address" id="business_address" class="form-control" v-bind:class="businessAddressHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="businessAddressHasError">
                            {{ errors.business_address[0]}}
                        </div>
                    </div>
                </div>
            
                <div class="row px-3">
                    <div class="form-group px-3 col-md-3">
                        <label for="number_of_dependents">No. of dependents</label>
                        <input value="" type="number" v-model="fields.number_of_dependents" id="number_of_dependents" class="form-control" v-bind:class="dependentsHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="dependentsHasError">
                            {{ errors.number_of_dependents[0]}}
                        </div>        
                        
                    </div>
                    <div class="form-group px-3 col-md-3">
                        <label for="household_size">Household Size</label>
                        <input type="" value="household_size" v-model="fields.household_size" id="household_size" class="form-control" v-bind:class="householdHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="householdHasError">
                            {{ errors.household_size[0]}}
                        </div>
                    </div>
                    <div class="form-group px-3 col-md-3">
                        <label for="years_of_stay_on_house">Years of Residency</label>
                        <input value="" type="number" v-model="fields.years_of_stay_on_house" id="years_of_stay_on_house" class="form-control" v-bind:class="yearsOfStayHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="yearsOfStayHasError">
                            {{ errors.years_of_stay_on_house[0]}}
                        </div>
                    </div>
            
                    <div class="form-group px-3 col-md-3 col-md-offset-2">
                        <label for="house_type">House Type</label>
                        <select v-model="fields.house_type" id="house_type" class="form-control" v-bind:class="houseTypeHasError ? 'is-invalid' : ''">
                            <option value="">Choose an option</option>
                            <option value="Owned">Owned</option>
                            <option value="Rented">Rented</option>
                        </select>
                        <div class="invalid-feedback" v-if="houseTypeHasError">
                            {{ errors.house_type[0]}}
                        </div>
                    </div>
            
                </div>
            
            
                <div class="row px-3">
                    <div class="form-group col-md-6">
                        <label for="spouse_name">Spouse Name</label>
                        <input value="" type="text" v-model="fields.spouse_name" class="form-control" id="spouse_name" v-bind:class="spouseNameHasError ? 'is-invalid' : ''" z>
                        <div class="invalid-feedback" v-if="spouseNameHasError">
                            {{ errors.spouse_name[0]}}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="spouse_contact_number">Spouse Contact Number</label>
                        <input value="" type="text" v-model="fields.spouse_contact_number" class="form-control" id="spouse_contact_number" v-bind:class="spouseContactHasError ? 'is-invalid' : ''" placeholder="09XXXXXXXXX" z>
                        <div class="invalid-feedback" v-if="spouseContactHasError">
                            {{ errors.spouse_contact_number[0]}}
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-md-offset-8">
                        <label for="spouse_birthday">Spouse Birthday</label>
                    
                        <date-picker v-bind:class="houseTypeHasError ? 'is-invalid' : ''" v-model="fields.spouse_birthday" name="spouse_birthday" id="spouse_birthday"  @datePicked="getDate($event, 'spouse_birthday')"></date-picker>
                        <div class="invalid-feedback" v-if="spouseBirthdayHasError">
                            {{ errors.spouse_birthday[0]}}
                        </div>
                    </div>
                </div>
            
                <h3 class="px-3 my-4 h3">Statutories</h3>
            
                <div class="row px-3">
                    <div class="form-group col-md-4">
                        <label>TIN</label>
                        <input value="" type="text" v-model="fields.tin" id="tin" v-bind:class="tinHasError ? 'is-invalid' : ''"  class="form-control">
                        <div class="invalid-feedback" v-if="tinHasError">
                            {{ errors.tin[0]}}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>SSS</label>
                        <input value="" type="text" v-model="fields.sss" id="sss" v-bind:class="sssHasError ? 'is-invalid' : ''" class="form-control">
                        <div class="invalid-feedback" v-if="sssHasError">
                            {{ errors.sss[0]}}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>UMID</label>
                        <input value="" type="text" v-model="fields.umid" id="umid" v-bind:class="umidHasError ? 'is-invalid' : ''" class="form-control">
                        <div class="invalid-feedback" v-if="umidHasError">
                            {{ errors.umid[0]}}
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-md-offset-6">
                        <label>Mothers Maiden Name</label>
                        <input value="" type="text" v-model="fields.mother_maiden_name" v-bind:class="motherMaidenNameHasError ? 'is-invalid' : ''" id="mother_maiden_name" class="form-control" z>
                        <div class="invalid-feedback" v-if="motherMaidenNameHasError">
                            {{ errors.mother_maiden_name[0]}}
                        </div>
                    </div>
                </div>
            
                <h3 class="px-3 my-4 h3">Employment Income</h3>
            
                <div class="row px-3">
                    <h3 class="col-md-6 px-3 my-2 h3">Personal</h3>
                    <h3 class="col-md-6 h3">Spouse</h3>
                    <div class="form-group col-md-3">
                        <div class="p0 form-check">
                            <label class="form-check-label" for="is_self_employed">
                                <input class="form-check-input cb-type" :disabled = "fields.is_employed" :class = "{disabled:fields.is_employed}" v-model ="fields.is_self_employed" id="is_self_employed" type="checkbox" name="is_self_employed" value="">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="is_self_employed">Self-Employed</label>
                            </label>
                        </div>
                        <div class="hi form-group p0 my-2" data-attribute="is_self_employed" :class="{active:fields.is_self_employed}">
                            <label for="sevice_type">Service Type</label>
                            <div class="select">
                                <select v-model="fields.service_type" id="service_type">
                                <option selected="selected" disabled="disabled">Choose an option</option> 
                                <option value="Agriculture"> Agriculture </option>
                                <option value="Trading/Merchandising"> Trading/Merchandising </option>
                                <option value="Manufacturing"> Manufacturing </option>
                                <option value="Service"> Service </option>
                                <option value="Others"> Others </option>
                                </select>
                            </div>
                        </div>
                        <div class="hi form-group p0 my-2" data-attribute="is_self_employed" :class="{active:fields.is_self_employed}">
                            <label for="service_type_gross_income">Monthly Income</label>
                            <input type="text" id="service_type_gross_income" v-model="fields.service_type_gross_income" class="form-control" value="service_type_gross_income">
                        </div>
                    </div>
            
                    <div class="form-group col-md-3">
                        <div class="p0 form-check">
                            <label class="form-check-label" for="is_employed">
                                <input class="form-check-input cb-type" id="is_employed" :disabled = "fields.is_self_employed" :class="{disabled:fields.is_self_employed}" type="checkbox" v-model="fields.is_employed">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="is_employed">Working on Company</label>
                            </label>
                        </div>
                        <div class="hi my-2" data-attribute="is_employed" :class="{active:fields.is_employed}">
                            <div class="row">
                                <div class="form-group w-100">
                                    <label for="employed_position">Position</label>
                                    <input value="" type="text" v-model="fields.employed_position" class="form-control" id="employed_position">
                                </div>
                                <div class="form-group w-100">
                                    <label for="employed_company_name">Company Name</label>
                                    <input value="" type="text" v-model="fields.employed_company_name" class="form-control" id="employed_company_name">
                                </div>
                                <div class="form-group w-100">
                                    <label for="employed_monthly_gross_income">Monthly Gross income</label>
                                    <input value="" type="text" v-model="fields.employed_monthly_gross_income" class="form-control" id="employed_monthly_gross_income">
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group col-md-3">
                        <div class="p0 form-check">
                            <label class="form-check-label" for="spouse_is_self_employed">
                                <input class="form-check-input cb-type" :disabled="fields.spouse_is_employed" id="spouse_is_self_employed" :class="{disabled:fields.spouse_is_employed}" type="checkbox" v-model="fields.spouse_is_self_employed" value="">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="spouse_is_self_employed">Spouse Self-Employed</label>
                            </label>
                        </div>
                        <div class="hi form-group col-md-12 p0 my-2" :class="{active:fields.spouse_is_self_employed}" data-attribute="spouse_is_self_employed">
                            <label for="spouse_service_type">Spouse Service Type</label>
                            <select v-model="fields.spouse_service_type" id="spouse_service_type" class="form-control">
                                <option selected="selected" disabled="disabled">Choose an option</option> 
                                <option value="Agriculture"> Agriculture </option>
                                <option value="Trading/Merchandising"> Trading/Merchandising </option>
                                <option value="Manufacturing"> Manufacturing </option>
                                <option value="Service"> Service </option>
                                <option value="Others"> Others </option>
                            </select>
                        </div>
                        <div class="hi form-group p0 my-2" :class="{active:fields.spouse_is_self_employed}" data-attribute="spouse_is_self_employed" >
                            <label for="spouse_service_type_gross_income">Monthly Income</label> 
                            <input type="text" id="spouse_service_type_gross_income" v-model="fields.spouse_service_type_gross_income" value="" class="form-control">
                        </div>
                    </div>
            
                    <div class="form-group col-md-3">
                        <div class="p0 form-check">
                            <label class="form-check-label" for="spouse_is_employed">
                                <input class="form-check-input cb-type" id="spouse_is_employed" type="checkbox" v-model="fields.spouse_is_employed" :disabled="fields.spouse_is_self_employed" :class="{disabled:fields.spouse_is_self_employed}">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="spouse_is_employed">Spouse Working on Company</label>
                            </label>
                        </div>
                        <div class="hi my-2" data-attribute="spouse_is_employed" :class="{active:fields.spouse_is_employed}">
                            <div class="row">
                                <div class="form-group w-100">
                                    <label for="spouse_employed_position">Position</label>
                                    <input value="" type="text" v-model="fields.spouse_employed_position" class="form-control" id="spouse_employed_position">
                                </div>
                                <div class="form-group w-100">
                                    <label for="spouse_company_name">Spouse Company Name</label>
                                    <input value="" type="text" v-model="fields.spouse_employed_company_name" class="form-control" id="spouse_employed_company_name">
                                </div>
                                <div class="form-group w-100">
                                    <label for="spouse_employed_monthly_gross_income">Spouse Monthly Gross income</label>
                                    <input value="" type="text" v-model="fields.spouse_employed_monthly_gross_income" class="form-control" id="spouse_employed_monthly_gross_income">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <h3 class="px-3 my-4 h3">Other Income</h3> 
                <div class="row px-3">
                    <div class="form-group col-md-3">
                        <div class="form-check p0">
                            <label class="form-check-label" for="has_remittance">
                                <input class="form-check-input cb-type" id="has_remittance" type="checkbox" v-model="fields.has_remittance" value="">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="has_remittance">Remittance</label>
                            </label>
                        </div>
                        <div class="hi form-group col-md-12 p0 my-2" :class="this.fields.has_remittance ? 'active' : ''" data-attribute="has_remittance">
                            <label for="remittance_amount">Remittance Amount</label>
                            <input value="" type="number" v-model="fields.remittance_amount" class="form-control" id="remittance_amount">
                        </div>
                    </div>
            
                    <div class="form-group col-md-3">
                        <div class="p0 form-check">
                            <label class="form-check-label" for="has_pension">
                                <input class="form-check-input cb-type" id="has_pension" type="checkbox" v-model="fields.has_pension">
                                <span class="form-check-sign">
                                <span class="check"></span>
                                </span>
                                <label for="has_pension">Pension</label>
                            </label>
                        </div>
                        <div class="hi form-group col-md-12 p0 my-2" :class="this.fields.has_pension ? 'active' : ''" data-attribute="has_pension">
                            <label for="pension_amount">Pension Amoount</label>
                            <input value="" type="number" v-model="fields.pension_amount" class="form-control" id="pension_amount">
                        </div>
                    </div>
                </div>
            
                <div class="row px-3 my-3">
                    <div class="form-group col-md-4 col-md-offset-8">
                        <label class="">Total household income</label>
                        <input type="text" class="form-control" v-bind:class="totalHouseholdIncomeHasError ? 'is-invalid' : ''"  :value="total_household_income">
                        <div class="invalid-feedback" v-if="totalHouseholdIncomeHasError">
                            {{ errors.total_household_income[0]}}
                        </div>
                    </div>
                </div>
            
                <h4 class="my-2 px-3 h3">Notes</h4>
                <div class="row px-3">
                    <div class="form-group col-md-12">
                        <textarea value="notes" rows="3" cols="40" v-model="fields.notes" class="form-control"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mx-3">Submit</button>
                </form>
          </div>
    </div>
</div>
  
  <div class="col-md-3">
     <div class="card">
         <div class="card-header">
             <h4 class="text-center h4">Attachment</h4>
         </div>

        <div class="card-body">
             
            <div  class="file-input-profile d-block text-center position-relative mb-4">
                <img :src="fields.profile_picture_path" class="img-thumbnail" alt="Cinque Terre" > 
                <div class="file-input text-center">
                    <span class="position-relative btn btn-rose btn-round btn-file">
                        <span class="fileinput-new">Image</span>
                        <input value="" type="file" class="attachment" name="profile_picture_path"  @change="onFileChange($event,'profile_picture_path')">
                    </span>
                </div>
            </div>
            <div  class="file-input-signature d-block text-center position-relative">
                <img :src="fields.signature_path" class="img-thumbnail" alt="Cinque Terre" > 
                <div class="file-input text-center">
                    <span class="position-relative btn btn-rose btn-round btn-file">
                    <span class="fileinput-new">Signature</span>
                    <input value="signature_path" type="file" class="attachment" name="signature_path" @change="onFileChange($event,'signature_path')">
                    </span>
                </div>
            </div>
         </div>
     </div>
 </div> 
</div>       
</template>

<script>

import SelectComponentV2 from './SelectComponentV2';
import Swal from 'sweetalert2';

export default {
    components: {
        SelectComponentV2
    },
    props:["clientId"],

    data(){
        return {
            fields: {
                'office_id':null,
                'firstname':null,
                'middlename':null,
                'lastname':null,
                'suffix':null,
                'nickname':null,
                'gender':null,
                'civil_status':null,
                'fb_account':null,
                'contact_number':null,
                'birthday':null,
                'birthplace':null,
                'education':null,
                'street_address':null,
                'barangay_address':null,
                'city_address':null,
                'province_address':null,
                'zipcode':null,
                'business_address':null,
                'number_of_dependents':null,
                'household_size':null,
                'years_of_stay_on_house':null,
                'house_type':null,
                'spouse_name':null,
                'spouse_contact_number':null,
                'spouse_birthday':null,
                'tin':null,
                'sss':null,
                'umid':null,
                'mother_maiden_name':null,

                'is_self_employed':false,
                'service_type':null,
                'service_type_gross_income':0,

                'is_employed':false,
                'employed_position':null,
                'employed_company_name':null,
                'employed_monthly_gross_income':0,

                'spouse_is_self_employed':false,
                'spouse_service_type':null,
                'spouse_service_type_gross_income':0,

                'spouse_is_employed':false,
                'spouse_employed_position':null,
                'spouse_employed_company_name':null,
                'spouse_employed_monthly_gross_income':0,

                'has_remittance':false,
                'remittance_amount':0,

                'has_pension':null,
                'pension_amount':0,

                'notes':null,

                'profile_picture_path': location.origin + '/assets/img/anime3.png',
                'signature_path': location.origin + '/assets/img/signature.png',
                
            },
            errors: {

            }
            


        }
    },
    mounted(){
        console.log(this.clientId);
            axios.get('/api/edit/client/'+this.clientId)
            .then(res => {
                
                this.fields.firstname = res.data[0].firstname,
                this.fields.middlename = res.data[0].middlename,
                this.fields.lastname = res.data[0].lastname,
                this.fields.suffix = res.data[0].suffix,
                this.fields.nickname = res.data[0].nickname,
                this.fields.gender = res.data[0].gender,
                this.fields.civil_status = res.data[0].civil_status,
                this.fields.fb_account = res.data[0].fb_account,
                this.fields.contact_number = res.data[0].contact_number,
                this.fields.birthday = res.data[0].birthday,
                this.fields.birthplace = res.data[0].birthplace,
                this.fields.education = res.data[0].education,
                this.fields.street_address = res.data[0].street_address,
                this.fields.barangay_address = res.data[0].barangay_address,
                this.fields.city_address = res.data[0].city_address,
                this.fields.province_address = res.data[0].province_address,
                this.fields.zipcode = res.data[0].zipcode,
                this.fields.business_address = res.data[0].business_address,
                this.fields.number_of_dependents = res.data[0].number_of_dependents,
                this.fields.household_size = res.data[0].household_size,
                this.fields.years_of_stay_on_house = res.data[0].years_of_stay_on_house,
                this.fields.house_type = res.data[0].house_type,
                this.fields.spouse_name = res.data[0].spouse_name,
                this.fields.spouse_birthday = res.data[0].spouse_birthday,
                this.fields.spouse_contact_number = res.data[0].spouse_contact_number,
                this.fields.tin = res.data[0].tin,
                this.fields.sss = res.data[0].sss,
                this.fields.umid = res.data[0].umid,
                this.fields.mother_maiden_name = res.data[0].mother_maiden_name,
                this.fields.profile_picture_path = res.data[0].profile_picture_path,
                this.fields.signature_path = res.data[0].signature_path,
                this.fields.notes = res.data[0].notes,


                // this.fields.is_self_employed = res.data[1].is_self_employed,
                // this.fields.service_type = res.data[1].service_type,
                // this.fields.service_type_gross_income = res.data[1].service_type_gross_income,
                // this.fields.is_employed = res.data[1].is_employed,
                // this.fields.employed_position = res.data[1].employed_position,
                // this.fields.employed_company_name = res.data[1].employed_company_name,
                // this.fields.employed_monthly_gross_income = res.data[1].employed_monthly_gross_income,

                // this.fields.spouse_is_self_employed = res.data[1].spouse_is_self_employed,
                // this.fields.spouse_service_type = res.data[1].spouse_service_type,
                // this.fields.spouse_service_type_gross_income = res.data[1].spouse_service_type_gross_income,

                // this.fields.spouse_is_employed = res.data[1].spouse_is_employed,                
                // this.fields.spouse_employed_position = res.data[1].spouse_employed_position,
                // this.fields.spouse_employed_company_name = res.data[1].spouse_employed_company_name,
                // this.fields.spouse_employed_monthly_gross_income = res.data[1].spouse_employed_monthly_gross_income,        
                // this.fields.has_pension = res.data[1].has_pension,
                // this.fields.pension_amount = res.data[1].pension_amount,

                // this.fields.has_remittance = res.data[1].has_remittance,                
                // this.fields.remittance_amount = res.data[1].remittance_amount,

                this.fields.office_id = res.data[0].office_id
            })
    },
    computed:{
        total_household_income(){
            var total = parseInt(this.fields.service_type_gross_income) + parseInt(this.fields.employed_monthly_gross_income) +  parseInt(this.fields.spouse_service_type_gross_income) +parseInt(this.fields.spouse_employed_monthly_gross_income) + parseInt(this.fields.remittance_amount) + parseInt(this.fields.pension_amount) 
            if(isNaN(total)){
                return 'Use positive integers for amounts only';
            }
            return total;
        },
        hasErrors(){
            return Object.keys(this.errors).length > 0;
        },
        officeHasError(){
            return this.errors.hasOwnProperty('office_id')
        },
        firstNameHasError(){
            return this.errors.hasOwnProperty('firstname')
        },
        middleNameHasError(){
            return this.errors.hasOwnProperty('middlename')
        },
        lastNameHasError(){
            return this.errors.hasOwnProperty('lastname')
        },
        suffixNameHasError(){
            return this.errors.hasOwnProperty('suffixName')
        },
        nickNameHasError(){
            return this.errors.hasOwnProperty('nickname')
        },
        genderHasError(){
            return this.errors.hasOwnProperty('gender')
        },
        civilStatusHasError(){
            return this.errors.hasOwnProperty('civil_status')
        },
        facebookHasError(){
            return this.errors.hasOwnProperty('facebook')
        },
        phoneHasError(){
            return this.errors.hasOwnProperty('contact_number')
        },
        birthplaceHasError(){
            return this.errors.hasOwnProperty('birthplace')
        },
        educationHasError(){
            return this.errors.hasOwnProperty('education')
        },
        streetHasError(){
            return this.errors.hasOwnProperty('street_address')
        },
        barangayHasError(){
            return this.errors.hasOwnProperty('barangay_address')
        },
        cityHasError(){
            return this.errors.hasOwnProperty('city_address')
        },
        provinceNameHasError(){
            return this.errors.hasOwnProperty('province_address')
        },
        zipCodeHasError(){
            return this.errors.hasOwnProperty('zipcode')
        },
        businessAddressHasError(){
            return this.errors.hasOwnProperty('business_address')
        },
        dependentsHasError(){
            return this.errors.hasOwnProperty('number_of_dependents')
        },
        householdHasError(){
            return this.errors.hasOwnProperty('household_size')
        },
        yearsOfStayHasError(){
            return this.errors.hasOwnProperty('years_of_stay_on_house')
        },
        houseTypeHasError(){
            return this.errors.hasOwnProperty('house_type')
        },
        spouseNameHasError(){
            return this.errors.hasOwnProperty('spouse_name')
        },
        spouseContactHasError(){
            return this.errors.hasOwnProperty('spouse_contact_number')
        },
        spouseBirthdayHasError(){
            return this.errors.hasOwnProperty('spouse_birthday')
        },
        tinHasError(){
            return this.errors.hasOwnProperty('tin')
        },
        sssHasError(){
            return this.errors.hasOwnProperty('sss')
        },
        umidHasError(){
            return this.errors.hasOwnProperty('umid')
        },
        motherMaidenNameHasError(){
            return this.errors.hasOwnProperty('mother_maiden_name')
        },
        totalHouseholdIncomeHasError(){
            return this.errors.hasOwnProperty('total_household_income')
        }
    },
    methods: {
        onFileChange(e,id) {
           
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0],id);
        },
        createImage(file,id) {
            var image = new Image();
            var reader = new FileReader();

            reader.onload = (e) => {
                this.fields[id] = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.image = '';
        },
        onChildClick(value){
            alert(this.fromChild)
        },
        assignOffice(value){
            this.fields.office_id = value
        },
        getDate(value, field){
           this.fields[field] = value
        },
        submit(){
            this.errors = {}
            this.fields['total_household_income'] = this.total_household_income
            axios.post('/api/edit/client/'+this.clientId, this.fields)
                .then(res=>{
                    console.log(res);
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
    }
}
</script>