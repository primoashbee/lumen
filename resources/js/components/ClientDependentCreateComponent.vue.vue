<template>
<div>
	<loading :is-full-page="true" :active.sync="isLoading" ></loading>
	<div class="card">
		
		<div class="card-header">
			<h3 class="h3">Insurance</h3>
		</div>
		<div class="card-body">
			<form @submit.prevent="submit">
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
							<select name="" id="packages" class="form-control" @change="packageSelected($event)">
								<option :value="null"> Please select package </option>
								<option  :value="item.id" v-for="item in items[this.civil_status]" :key="item.id">{{item.description}}</option>
								
							</select>
						</div>
						<div id="s_package_1" v-if="selected==101">
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="mother">
											<input class="form-check-input cb-type" id="mother" type="checkbox" v-model="form.mother.exists" @change="toggleForm($event,'mother')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="mother">Mother</label>
										</label>
									</div>
								</div>
							</div>
							<div class="row py-4" v-if="showForm('mother')">
								<h5 class="h5 col-lg-12">Mothers Information</h5>
								<div class="form-group col-lg-4">
									<label for="mother_firstname">First Name</label>
									<input type="text" class="form-control" id="mother_firstname" v-model="form.mother.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="mother_middlename">Middle Name</label>
									<input type="text" class="form-control" id="mother_middlename" v-model="form.mother.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="mother_lastname">Last Name</label>
									<input type="text" class="form-control" id="mother_lastname" v-model="form.mother.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="mother_birthday">Birthday</label>
									<input type="date" class="form-control" id="mother_birthday" v-model="form.mother.birthday">
								</div>
							</div>
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="father">
											<input class="form-check-input cb-type" id="father" type="checkbox" v-model="form.father.exists" @change="toggleForm($event,'father')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="father">Father</label>
										</label>
									</div>
								</div>
							</div>

							<div class="row py-4" v-if="showForm('father')">
								<h5 class="h5 col-lg-12">Fathers Information</h5>
								<div class="form-group col-lg-4">
									<label for="father_firstname">First Name</label>
									<input type="text" class="form-control" id="father_firstname" v-model="form.father.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="father_middlename">Middle Name</label>
									<input type="text" class="form-control" id="father_middlename" v-model="form.father.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="father_lastname">Last Name</label>
									<input type="text" class="form-control" id="father_lastname" v-model="form.father.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="father_birthday">Birthday</label>
									<input type="date" class="form-control" id="father_birthday" v-model="form.father.birthday">
								</div>
							</div>
						</div>

						<div id="s_package_2" v-if="selected==102">

							<div class="row py-4">
								<div class="col-lg-12 pb-4">
									<div class="form-check p0">
										<label class="form-check-label" for="sibling_1">	
											<input class="form-check-input cb-type" id="sibling_1" type="checkbox" :disabled="nextLevelExists('sibling_2')" v-model="form.sibling_1.exists" @change="toggleForm($event,'sibling_1')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="sibling_1">Sibling 1 Information</label>
										</label>
									</div>
								</div>
								<div class="col-lg-12 row"  v-if="showForm('sibling_1')">
									<div class="form-group col-lg-4">
										<label for="sibling1_firstname">First Name</label>
										<input type="text" class="form-control" id="sibling1_firstname" v-model="form.sibling_1.firstname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_middlename">Middle Name</label>
										<input type="text" class="form-control" id="sibling1_middlename" v-model="form.sibling_1.middlename">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_lastname">Last Name</label>
										<input type="text" class="form-control" id="sibling1_lastname" v-model="form.sibling_1.lastname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_birthday">Birthday</label>
										<input type="date" class="form-control" id="sibling1_birthday" v-model="form.sibling_1.birthday">
									</div>
								</div>
							</div>

							<div class="row py-4" v-if="form.sibling_1.exists">
								<div class="col-lg-12 pb-4">
									<div class="form-check p0">
										<label class="form-check-label" for="sibling_2">
											<input class="form-check-input cb-type" id="sibling_2" type="checkbox" :disabled="nextLevelExists('sibling_3')" v-model="form.sibling_2.exists" @change="toggleForm($event,'sibling_2')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="sibling_2">Sibling 2 Information</label>
										</label>
									</div>
								</div>
								<div class="col-lg-12 row"  v-if="showForm('sibling_2')">
									<div class="form-group col-lg-4">
										<label for="sibling1_firstname">First Name</label>
										<input type="text" class="form-control" id="sibling1_firstname" v-model="form.sibling_2.firstname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_middlename">Middle Name</label>
										<input type="text" class="form-control" id="sibling1_middlename" v-model="form.sibling_2.middlename">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_lastname">Last Name</label>
										<input type="text" class="form-control" id="sibling1_lastname" v-model="form.sibling_2.lastname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_birthday">Birthday</label>
										<input type="date" class="form-control" id="sibling1_birthday" v-model="form.sibling_2.birthday">
									</div>
								</div>
							</div>

							<div class="row py-4" v-if="form.sibling_2.exists">
								<div class="col-lg-12 pb-4" >
									<div class="form-check p0">
										<label class="form-check-label" for="sibling_3">
											<input class="form-check-input cb-type" id="sibling_3" type="checkbox" v-model="form.sibling_3.exists" @change="toggleForm($event,'sibling_3')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="sibling_3">Sibling 3 Information</label>
										</label>
									</div>
								</div>
								<div class="col-lg-12 row"  v-if="showForm('sibling_3')">
									<div class="form-group col-lg-4">
										<label for="sibling1_firstname">First Name</label>
										<input type="text" class="form-control" id="sibling1_firstname" v-model="form.sibling_3.firstname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_middlename">Middle Name</label>
										<input type="text" class="form-control" id="sibling1_middlename" v-model="form.sibling_3.middlename">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_lastname">Last Name</label>
										<input type="text" class="form-control" id="sibling1_lastname" v-model="form.sibling_3.lastname">
									</div>
									<div class="form-group col-lg-4">
										<label for="sibling1_birthday">Birthday</label>
										<input type="date" class="form-control" id="sibling1_birthday" v-model="form.sibling_3.birthday">
									</div>
								</div>
							</div>



						</div>
						<div id="s_package_3" v-if="selected==103">
							<div class="row py-4">
								<div class="col-lg-12 pb-4">
									<div class="form-check p0">
										<label class="form-check-label" for="child_1">
											<input class="form-check-input cb-type" id="child_1" type="checkbox" :disabled="nextLevelExists('child_2')" v-model="form.child_1.exists" @change="toggleForm($event,'child_1')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_1">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="col-lg-12 row"  v-if="showForm('child_1')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child_1_firstname" v-model="form.child_1.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child_1_middlename" v-model="form.child_1.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child_1_lastname" v-model="form.child_1.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child_1_birthday" v-model="form.child_1.birthday">
								</div>
							</div>
							<div class="row py-4" v-if="form.child_1.exists">
								<div class="col-lg-12 pb-4">
									<div class="form-check p0">
										<label class="form-check-label" for="child_2">
											<input class="form-check-input cb-type" id="child_2" type="checkbox" :disabled="nextLevelExists('child_3')" v-model="form.child_2.exists" @change="toggleForm($event,'child_2')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_2">Child 2 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="col-lg-12 row"  v-if="showForm('child_2')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child_2_firstname" v-model="form.child_2.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child_2_middlename" v-model="form.child_2.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child_2_lastname" v-model="form.child_2.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child_2_birthday" v-model="form.child_2.birthday">
								</div>
							</div>
							<div class="row py-4" v-if="form.child_2.exists">
								<div class="col-lg-12 pb-4">
									<div class="form-check p0">
										<label class="form-check-label" for="child_3">
											<input class="form-check-input cb-type" id="child_3" type="checkbox" v-model="form.child_3.exists" @change="toggleForm($event,'child_3')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_3">Child 3 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="col-lg-12 row"  v-if="showForm('child_2')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child_3_firstname" v-model="form.child_3.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child_3_middlename" v-model="form.child_3.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child_3_lastname" v-model="form.child_3.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child_3_birthday" v-model="form.child_3.birthday">
								</div>
							</div>


						</div>
						<div id="m_package_1" v-if="selected==201">
							<div class="row py-4">
								<h5 class="h5 col-lg-12">Spouse Information</h5>
								<div class="form-group col-lg-4">
									<label for="spouse_firstname">First Name</label>
									<input type="text" class="form-control" id="spouse_firstname" v-model="form.spouse.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_middlename">Middle Name</label>
									<input type="text" class="form-control" id="spouse_middlename" v-model="form.spouse.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_lastname">Last Name</label>
									<input type="text" class="form-control" id="spouse_lastname" v-model="form.spouse.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_birthday">Birthday</label>
									<input type="date" class="form-control" id="mother_birthday" v-model="form.spouse.birthday">
								</div>
							</div>
						</div>
						<div id="m_package_2" v-if="selected==202">
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_1">
											<input class="form-check-input cb-type" id="child_1" type="checkbox" :disabled="nextLevelExists('child_2')" v-model="form.child_1.exists" @change="toggleForm($event,'child_1')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_1">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_1')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_1.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_1.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_1.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_1.birthday">
								</div>
							</div>
							
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_2">
											<input class="form-check-input cb-type" id="child_2" type="checkbox" :disabled="nextLevelExists('child_3')" v-model="form.child_2.exists" @change="toggleForm($event,'child_2')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_2">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_2')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_2.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_2.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_2.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_2.birthday">
								</div>
							</div>
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_3">
											<input class="form-check-input cb-type" id="child_3" type="checkbox"  v-model="form.child_3.exists" @change="toggleForm($event,'child_3')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_3">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_3')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_3.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_3.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_3.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_3.birthday">
								</div>
							</div>
						</div>

						<div id="m_package_3" v-if="selected==203">
							<div class="row py-4">
								<h5 class="h5 col-lg-12">Spouse Information</h5>
								<div class="form-group col-lg-4">
									<label for="spouse_firstname">First Name</label>
									<input type="text" class="form-control" id="spouse_firstname" v-model="form.spouse.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_middlename">Middle Name</label>
									<input type="text" class="form-control" id="spouse_middlename" v-model="form.spouse.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_lastname">Last Name</label>
									<input type="text" class="form-control" id="spouse_lastname" v-model="form.spouse.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="spouse_birthday">Birthday</label>
									<input type="date" class="form-control" id="mother_birthday" v-model="form.spouse.birthday">
								</div>
							</div>
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_1">
											<input class="form-check-input cb-type" id="child_1" type="checkbox" :disabled="nextLevelExists('child_2')" v-model="form.child_1.exists" @change="toggleForm($event,'child_1')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_1">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_1')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_1.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_1.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_1.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_1.birthday">
								</div>
							</div>
							
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_2">
											<input class="form-check-input cb-type" id="child_2" type="checkbox" :disabled="nextLevelExists('child_3')" v-model="form.child_2.exists" @change="toggleForm($event,'child_2')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_2">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_2')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_2.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_2.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_2.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_2.birthday">
								</div>
							</div>
							<div class="row py-4">
								<div class="col-lg-12">
									<div class="form-check p0">
										<label class="form-check-label" for="child_3">
											<input class="form-check-input cb-type" id="child_3" type="checkbox"  v-model="form.child_3.exists" @change="toggleForm($event,'child_3')">
											<span class="form-check-sign">
											<span class="check"></span>
											</span>
											<label class="t-white text-xl" for="child_3">Child 1 Information</label>
										</label>
									</div>
								</div>	
							</div>
							<div class="row " v-if="showForm('child_3')">
								<div class="form-group col-lg-4">
									<label for="child1_firstname">First Name</label>
									<input type="text" class="form-control" id="child1_firstname" v-model="form.child_3.firstname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_middlename">Middle Name</label>
									<input type="text" class="form-control" id="child1_middlename" v-model="form.child_3.middlename">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_lastname">Last Name</label>
									<input type="text" class="form-control" id="child1_lastname" v-model="form.child_3.lastname">
								</div>
								<div class="form-group col-lg-4">
									<label for="child1_birthday">Birthday</label>
									<input type="date" class="form-control" id="child1_birthday" v-model="form.child_3.birthday">
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import Swal from 'sweetalert2';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
	components: {
		Loading 
	},
	props:['id','civil_status','type'],
	data(){
		return {
			isLoading:false,
			items: {
				single: [
					{'id':101,'description':'Single - Parents (Mother / Father or Both)'},
					{'id':102,'description':'Single - Siblings (Max of 3)'},
					{'id':103,'description':'Single - Single Parent - Children (Max of 3)'},
				],
				married:[
					{'id':201,'description':'Married - Spouse'},
					{'id':202,'description':'Married - Children (Max of 3)'},
					{'id':203,'description':'Married - Spouse, Children (Max of 3)'}
				]
			},
			form:{
				type: "",
				package: "",
			},
			selected: null,
			shown : [],
		}
	},
	mounted(){
		if(this.type=="" || this.type == "null"){
			this.form.type = 'create'
		}else if(this.type=="update"){
			this.form.type = 'update'
		}
	},
	methods:{
		packageSelected(event){
			this.form = []
			let value = event.target.value
			this.form.package = value
			this.selected = value
			if(value==101){
				this.form.mother = {}
				this.form.mother.exists = false
				this.form.father ={}
				this.form.father.exists =false
			}
			if(value==102){
				this.form.sibling_1 = {}
				this.form.sibling_1.exists = false
				
				this.form.sibling_2 = {}
				this.form.sibling_2.exists = false
				
				this.form.sibling_3= {}
				this.form.sibling_3.exists = false
				
			}
			if(value==103){
				this.form.child_1 = {}
				this.form.child_1.exists = false

				this.form.child_2 = {}
				this.form.child_2.exists = false

				this.form.child_3 = {}
				this.form.child_3.exists = false
			}
			if(value==201){
				this.form.spouse = {}
				this.form.spouse.exists = true
			}
			if(value==202){
				this.form.child_1 = {}
				this.form.child_1.exists = false

				this.form.child_2 = {}
				this.form.child_2.exists = false

				this.form.child_3 = {}
				this.form.child_3.exists = false
			}
			if(value==203){
				this.form.spouse = {}
				this.form.spouse.exists = true

				this.form.child_1 = {}
				this.form.child_1.exists = false

				this.form.child_2 = {}
				this.form.child_2.exists = false

				this.form.child_3 = {}
				this.form.child_3.exists = false
			}
		},
		toggleForm(event,field){
			if(event.target.checked){
				return this.shown.push(field)
			}
			return this.shown.pop(field)
			
		
		},
		showForm(field){
			return this.shown.includes(field)
		},
		nextLevelExists(field){
			return this.shown.includes(field)
		},
		submit(){
			
			axios.post(this.axiosUrl, this.form)
			// .catch(error=>{
			// 	this.isLoading = false
			// 	this.errors = error.response.data.errors || {}
			// 	if(this.duplicateClient){
			// 		Swal.fire({
			// 			icon: 'error',
			// 			title: '<span style="font-family:\'Open Sans\', sans-serif!important;color:black;font-size:1.875;font-weight:600">OOPPPSSSSS!</span>',
			// 			text: this.errors.client.msg,
			// 			footer: '<a href="#">Client ['+this.errors.client.client_id+'] already existing at: ' +this.errors.client.exists_at +'</a>'
			// 		})
			// 	}
            //     })
		}

	},
	computed: {
		axiosUrl(){
			if(this.form.type=="create"){
				return '/client/create/dependent';
			}else if(this.form.type =="update"){
				return '/client/update/dependent';
			}
		}
	}

}
</script>