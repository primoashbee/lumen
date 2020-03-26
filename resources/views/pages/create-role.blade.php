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
					<div class="permission-table">
						<table class="table">
							<thead>
								<tr>
									<td colspan="3"><p class="title">Name</p></td>
									<td><p class="title">View</p></td>
									<td><p class="title">Edit</p></td>
									<td><p class="title">Create</p></td>
									<td><p class="title">Change Status</p></td>
								</tr>
							</thead>
							<tbody>
								<!-- <tr>
									<td>
										
									</td>
								</tr> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection