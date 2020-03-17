@extends('layouts.user')
@section('content')

<div class="content pl-32 pr-8 mt-4" id="content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<!-- <h3 class="h3">List Of Partner Clients</h3> -->
							<!-- <div class="row">
								<div class="col-md-6 col-md-offset-6">
									<div class="row">
										<div class="col-md-3">
											<label>Branch</label>
											<input type="text" name="brance" class="form-control" list="branches">
											<datalist id="branches">
												<option>ANGELES</option>
												<option>TARLAC</option>
												<option>CAPAS</option>
												<option>GUAGUA</option>
											</datalist>
										</div>
									</div>
								</div>
							</div> -->
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<label class="entries">
										Show
									 <select>
									 	<option>10</option>
									 	<option>25</option>
									 	<option>50</option>
									 	<option>100</option>
									 </select>
										entries
									</label>
								</div>
								<div class="col-md-6">
									<input type="text" name="search" class="form-control float-right" placeholder="Search Client" id="search">
								</div>
							</div>
							<table class="table">
								<thead>
									<tr>
										<td><p class="title">Full Name</p></td>
										<td><p class="title">Client ID</p></td>
										<td><p class="title">Status</p></td>
										<td><p class="title">Actions</p></td>
									</tr>
								</thead>
								<tbody>
									<tr class="py-3">
										<td>
											<p class="text-mute">NELSON TAN</p>
										</td>
										<td>
											<p class="text-mute">PC-ANG1000</p>
										</td>
										<td>
											<span class="active position-relative px-2">
						                      Active
						                    </span>
										</td>
										<td>
											
											<a href="" class="actions">
												<i class="fas fa-pencil-alt"></i>
											</a>
											<a href="" class="actions mx-2">
												<i class="fas fa-search"></i>
											</a>
										</td>
									</tr>
									<tr class="py-3">
										<td>
											<p class="text-mute">NELSON TAN</p>
										</td>
										<td>
											<p class="text-mute">PC-ANG1000</p>
										</td>
										<td>
											<span class="active position-relative px-2">
						                      Active
						                    </span>
										</td>
										<td>
											
											<a href="" class="actions">
												<i class="fas fa-pencil-alt"></i>
											</a>
											<a href="" class="actions mx-2">
												<i class="fas fa-search"></i>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="float-right">
								<ul class="pagination">
									<li><button>FIRST</button></li>
									<li><button>PREVIOUS</button></li>
									<li><a href="">1</a></li>
									<li><a href="">2</a></li>
									<li><a href="">3</a></li>
									<li><a href="">4</a></li>
									<li><a href="">5</a></li>
									<li><button>NEXT</button></li>
									<li><button>LAST</button></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
