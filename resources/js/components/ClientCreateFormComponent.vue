<template>
<div>
<form @submit.prevent="submit">
<h3 class="px-3">Basic Information</h3>
<div class="row px-3">
<div class="form-group col-md-6 col-lg-3">
    <label for="client_id">Linked To</label>
    <v2-select @officeSelected="assignOffice"></v2-select>
</div>
<div class="form-group col-md-3 col-lg-3">
    <label for="firstname">First Name</label>
    <input value="" type="text" id="firstname" v-model="fields.firstname" class="form-control" z>
    <div class="invalid-feedback">
        Please choose a username.
    </div>
</div>
<div class="form-group col-md-3">
    <label for="middlename">Middle name</label>
    <input value="" type="text" id="middlename" v-model="fields.middlename" class="form-control">
</div>
<div class="form-group col-md-3">
    <label for="lastname">Last name</label>
    <input value="" id="lastname" type="text" v-model="fields.lastname" class="form-control" z>
</div>
</div>
<div class="row px-3">
    <div class="form-group col-md-2">
        <label for="suffix">Suffix </label>
        <input value="" type="text" v-model="fields.suffix" id="suffix" class="form-control" >
    </div>

    <div class="form-group col-md-3">
        <label for="nickname">Nickname</label>
        <input value="" type="text" v-model="fields.nickname" id="nickname" class="form-control">
    </div>

    <div class="form-group px-3 col-md-3">
        <label for="gender">Gender</label>
        <div class="select">
            <select v-model="fields.gender" id="gender">
                <option selected disabled>Choose an option</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>

    <div class="form-group col-md-4 px-3">
        <label for="civil_status">Marital Status</label>
        <div class="select">
            <select v-model="fields.civil_status" id="civil_status">
            <option selected disabled>Choose an option</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
            </select>
        </div>
    </div>

</div>
<div class="row px-3">
    <div class="form-group col-md-6">
        <label id="fb_account">Facebook Account</label>
        <input value="" type="text" v-model="fields.fb_account" id="fb_account" class="form-control" z>
    </div>
    <div class="form-group col-md-6">
        <label id="contact_number">Phone Number</label>
        <input value="" type="text" placeholder="09XXXXXXXXX" v-model="fields.contact_number" id="contact_number" class="form-control" z>
    </div>
</div>
<div class="row px-3">

    <div class="form-group col-md-3 px-3">
        <label for="birthday">Date Of Birth</label>
        <date-picker id="birthday" v-model="fields.birthday" @datePicked="getDate($event, 'birthday')" ></date-picker>
    </div>

    <div class="form-group col-md-4 px-3">
        <label for="birthplace">Birthplace</label>
        <input value="" id="birthplace" type="text" class="form-control" v-model="fields.birthplace" z autocomplete="birthplace">
    </div>


    <div class="form-group col-md-5 px-3">
        <label for="education">Educational Attainment</label>
        <div class="select">
            <select v-model="fields.education" id="education">
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
        <input value="" type="text" v-model="fields.street_address" id="street_address" class="form-control" z>
    </div>
    <div class="form-group col-md-3 px-2">
        <label for="barangay_address">Barangay</label>
        <input value="" type="text" v-model="fields.barangay_address" id="barangay_address" class="form-control" z>
    </div>
</div>
<div class="row px-3">
    <div class="form-group col-md-4">
        <label for="city_address">City</label>
        <input value="" type="text" v-model="fields.city_address" id="city_address" class="form-control" z>
    </div>
    <div class="form-group col-md-4">
        <label for="province_address">Province</label>
        <input value="" type="text" v-model="fields.province_address" id="province_address" class="form-control" z>
    </div>
    <div class="form-group col-md-4 px-2">
        <label for="zipcode">Postal/Zip code</label>
        <input value="" type="text" v-model="fields.zipcode" id="zipcode" class="form-control" z>
    </div>
</div>
<h3 class="px-3 my-3 h3">Family Information</h3>	
<div class="row px-3">
    <div class="form-group col-md-12">
        <label for="business_address">Full Business Address</label>
        <input value="" type="text" v-model="fields.business_address" id="business_address" class="form-control" z>
    </div>
</div>

<div class="row px-3">
    <div class="form-group px-3 col-md-3">
        <label for="number_of_dependents">No. of dependents</label>
        <input value="" type="number" v-model="fields.number_of_dependents" id="number_of_dependents" class="form-control" z>
    </div>
    <div class="form-group px-3 col-md-3">
        <label for="household_size">Household Size</label>
        <input type="" value="household_size" v-model="fields.household_size" id="household_size" class="form-control" z>
    </div>
    <div class="form-group px-3 col-md-3">
        <label for="years_of_stay_on_house">Years of Residency</label>
        <input value="" type="number" v-model="fields.years_of_stay_on_house" id="years_of_stay_on_house" class="form-control" z>
    </div>

    <div class="form-group px-3 col-md-3 col-md-offset-2">
        <label for="house_type">House Type</label>
        <select v-model="fields.house_type" id="house_type" class="form-control">
            <option value="">Choose an option</option>
            <option value="Owned">Owned</option>
            <option value="Rented">Rented</option>
        </select>
    </div>

</div>


<div class="row px-3">
    <div class="form-group col-md-6">
        <label for="spouse_name">Spouse Name</label>
        <input value="" type="text" v-model="fields.spouse_name" class="form-control" id="spouse_name" z>
    </div>
    <div class="form-group col-md-6">
        <label for="spouse_contact_number">Spouse Contact Number</label>
        <input value="" type="text" v-model="fields.spouse_contact_number" class="form-control" id="spouse_contact_number" placeholder="09XXXXXXXXX" z>
    </div>
    <div class="form-group col-md-4 col-md-offset-8">
        <label for="spouse_birthday">Spouse Birthday</label>
       
        <date-picker v-model="fields.spouse_birthday" name="spouse_birthday" id="spouse_birthday"  @datePicked="getDate($event, 'spouse_birthday')"></date-picker>
    </div>
</div>

<h3 class="px-3 my-4 h3">Statutories</h3>

<div class="row px-3">
    <div class="form-group col-md-4">
        <label>TIN</label>
        <input value="" type="text" v-model="fields.tin" id="tin" class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label>SSS</label>
        <input value="" type="text" v-model="fields.sss" id="sss" class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label>UMID</label>
        <input value="" type="text" v-model="fields.umid" id="umid" class="form-control">
    </div>
    <div class="form-group col-md-6 col-md-offset-6">
        <label>Mothers Maiden Name</label>
        <input value="" type="text" v-model="fields.mother_maiden_name" id="mother_maiden_name" class="form-control" z>
    </div>
</div>

<h3 class="px-3 my-4 h3">Employment Income</h3>

<div class="row px-3">
    <h3 class="col-md-6 px-3 my-2 h3">Personal</h3>
    <h3 class="col-md-6 h3">Spouse</h3>
    <div class="form-group col-md-3">
        <div class="p0 form-check">
            <label class="form-check-label" for="is_self_employed">
                <input class="form-check-input cb-type" v-model ="fields.is_self_employed" id="is_self_employed" type="checkbox" name="is_self_employed" value="">
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
                <label for="is_self_employed">Self-Employed</label>
            </label>
        </div>
        <div class="hi form-group p0 my-2" data-attribute="is_self_employed">
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
        <div class="hi form-group p0 my-2" data-attribute="is_self_employed">
            <label for="service_type_gross_income">Monthly Income</label>
            <input type="text" id="service_type_gross_income" v-model="fields.service_type_gross_income" class="form-control" value="service_type_gross_income">
        </div>
    </div>

    <div class="form-group col-md-3">
        <div class="p0 form-check">
            <label class="form-check-label" for="is_employed">
                <input class="form-check-input cb-type" id="is_employed" type="checkbox" v-model="fields.is_employed">
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
                <input class="form-check-input cb-type" id="spouse_is_self_employed" type="checkbox" v-model="fields.spouse_is_self_employed" value="">
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
                <label for="spouse_is_self_employed">Spouse Self-Employed</label>
            </label>
        </div>
        <div class="hi form-group col-md-12 p0 my-2" data-attribute="spouse_is_self_employed">
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
        <div class="hi form-group p0 my-2" data-attribute="spouse_is_self_employed" >
            <label for="spouse_service_type_gross_income">Monthly Income</label> 
            <input type="text" id="spouse_service_type_gross_income" v-model="fields.spouse_service_type_gross_income" value="" class="form-control">
        </div>
    </div>

    <div class="form-group col-md-3">
        <div class="p0 form-check">
            <label class="form-check-label" for="spouse_is_employed">
                <input class="form-check-input cb-type" id="spouse_is_employed" type="checkbox" v-model="fields.spouse_is_employed" value="">
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
                <label for="spouse_is_employed">Spouse Working on Company</label>
            </label>
        </div>
        <div class="hi my-2" data-attribute="spouse_is_employed">
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

<h3 class="px-3 my-4">Other Income</h3>	
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
        <div class="hi form-group col-md-12 p0 my-2" data-attribute="has_remittance">
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
        <div class="hi form-group col-md-12 p0 my-2" data-attribute="has_pension">
            <label for="pension_amount">Pension Amoount</label>
            <input value="" type="number" v-model="fields.pension_amount" class="form-control" id="pension_amount">
        </div>
    </div>
</div>

<div class="row px-3 my-3">
    <div class="form-group col-md-4 col-md-offset-8">
        <label class="">Total household income</label>
        <input type="text" class="form-control" :value="total_household_income">
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
</template>

<script>

import SelectComponentV2 from './SelectComponentV2';
import Swal from 'sweetalert2';

export default {
    components: {
        SelectComponentV2
    },
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

                'notes':null
            },
            errors: {

            }
            


        }
    },
    computed:{
        total_household_income(){
            var total = parseInt(this.fields.service_type_gross_income) + parseInt(this.fields.employed_monthly_gross_income) +  parseInt(this.fields.spouse_service_type_gross_income) +parseInt(this.fields.spouse_employed_monthly_gross_income) + parseInt(this.fields.remittance_amount) + parseInt(this.fields.pension_amount) 
            if(isNaN(total)){
                return 'Use positive integers for amounts only';
            }
            return total;
        }
    },
    methods: {
        onChildClick(value){
            alert(this.fromChild)
        },
        assignOffice(value){
            
            this.fields.office_id = value['id']
        },
        getDate(value, field){
           this.fields[field] = value
        },
        submit(){
            this.errors = {}
            this.fields['total_household_income'] = this.total_household_income
            axios.post('/create/client', this.fields)
                .then(res=>{
                    Swal.fire({
                        title: 'Success',
                        text: res.data.msg,
                        icon: 'success',
                        confirmButtonText: 'Cool'
                    })
                })
                .catch(error=>{
                    this.errors = error.response.data.errors || {}
                })
        }
    }
}
</script>

<style scoped>
    h2,
    .swal2-title { color:#161824 !important}
</style>

