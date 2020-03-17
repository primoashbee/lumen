@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
	<form class="row">
		<div class="col-lg-9">
			<div class="card">
				<div class="card-header">
					<h3 class="h3">Create Role</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label for="name">Role Name</label>
						<input type="text" name="name" class="form-control col-lg-6" id="name">
					</div>
					<div class="permission-table mb-8">
						<table class="table">
							<thead>
								<tr>
									<td><p class="title">Name</p></td>
									<td><p class="title">View</p></td>
									<td><p class="title">Edit</p></td>
									<td><p class="title">Create</p></td>
									<td><p class="title">Change Status</p></td>
									<td><p class="title">Approve Account	</p></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										Loan
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_loan">
		                                     <input class="form-check-input cb-type" id="view_loan" type="checkbox" name="view_loan">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_loan">
		                                     <input class="form-check-input cb-type" id="edit_loan" type="checkbox" name="edit_loan">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_loan">
		                                     <input class="form-check-input cb-type" id="create_loan" type="checkbox" name="create_loan">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="change_status_loan">
		                                     <input class="form-check-input cb-type" id="change_status_loan" type="checkbox" name="change_status_loan">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="approve_loan_account">
		                                     <input class="form-check-input cb-type" id="approve_loan_account" type="checkbox" name="approve_loan_account">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

								</tr>
								<tr>
									<td>
										Deposit
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_deposit">
		                                     <input class="form-check-input cb-type" id="view_deposit" type="checkbox" name="view_deposit">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_deposit">
		                                     <input class="form-check-input cb-type" id="edit_deposit" type="checkbox" name="edit_deposit">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_deposit">
		                                     <input class="form-check-input cb-type" id="create_deposit" type="checkbox" name="create_deposit">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="change_status_deposit">
		                                     <input class="form-check-input cb-type" id="change_status_deposit" type="checkbox" name="change_status_deposit">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="approve_deposit_account">
		                                     <input class="form-check-input cb-type" id="approve_deposit_account" type="checkbox" name="approve_deposit_account">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

								</tr>

								<tr>
									<td>
										Client
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_client">
		                                     <input class="form-check-input cb-type" id="view_client" type="checkbox" name="view_client">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_client">
		                                     <input class="form-check-input cb-type" id="edit_client" type="checkbox" name="edit_client">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_client">
		                                     <input class="form-check-input cb-type" id="create_client" type="checkbox" name="create_client">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="change_status_client">
		                                     <input class="form-check-input cb-type" id="change_status_client" type="checkbox" name="change_status_client">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="approve_client">
		                                     <input class="form-check-input cb-type" id="approve_client" type="checkbox" name="approve_client">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

								</tr>

								<tr>
									<td>
										Co-Maker
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_co_maker">
		                                     <input class="form-check-input cb-type" id="view_co_maker" type="checkbox" name="view_co_maker">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_comaker">
		                                     <input class="form-check-input cb-type" id="edit_comaker" type="checkbox" name="edit_comaker">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_comaker">
		                                     <input class="form-check-input cb-type" id="create_comaker" type="checkbox" name="create_comaker">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									<td colspan="2"></td>
								</tr>

								<tr>
									<td>
										Fees
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_fees">
		                                     <input class="form-check-input cb-type" id="view_fees" type="checkbox" name="view_fees">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_fees">
		                                     <input class="form-check-input cb-type" id="edit_fees" type="checkbox" name="edit_fees">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_fees">
		                                     <input class="form-check-input cb-type" id="create_fees" type="checkbox" name="create_fees">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									<td colspan="2"></td>
								</tr>

								<tr>
									<td>
										Penalties
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_penalty">
		                                     <input class="form-check-input cb-type" id="view_penalty" type="checkbox" name="view_penalty">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="edit_penalty">
		                                     <input class="form-check-input cb-type" id="edit_penalty" type="checkbox" name="edit_penalty">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>

									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="create_penalty">
		                                     <input class="form-check-input cb-type" id="create_penalty" type="checkbox" name="create_penalty">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									<td colspan="2"></td>
								</tr>
								<tr>
									<td>
										Reports
									</td>
									<td>
										<div class="p0 form-check">
		                                   <label class="form-check-label" for="view_reports">
		                                     <input class="form-check-input cb-type" id="view_reports" type="checkbox" name="view_reports">
		                                     <span class="form-check-sign">
		                                       <span class="check"></span>
		                                     </span>
		                                   </label>
		                               </div>
									</td>
									<td colspan="4"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-primary ml-2">Cancel</button>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection