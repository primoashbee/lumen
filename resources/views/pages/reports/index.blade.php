@extends('layouts.user')
@section('content')
	<div class="content content pl-32 pr-2 mt-4" id="content-full">
		<div class="row setting-wrapper">
			<div class="col-lg-9 pr-0 setting-container">
				<div class="row">
					<div class="filters-container d-inline-block mb-4 col-md-6">
						<h4 class="h4 d-inline-block">Filter:</h4>
						<div class="btn-filter-group ml-4 d-inline-block">
							<button data-filter="*" class="btn-filters">Show All</button>
							<button data-filter=".structure" class="btn-filters">Offices</button>
							<button data-filter=".loans" class="btn-filters">Loan</button>
							<button data-filter=".deposit" class="btn-filters">Deposit</button>
							<button data-filter=".reports" class="btn-filters">Reports</button>
							<button data-filter=".user" class="btn-filters">Users</button>
						</div>
					</div>

					<div class="col-md-5 d-flex">
						<h4 class="h4">Search:</h4>
						<input type="text" id="search_menu" class="ml-4 d-inline-block form-control">
					</div>

				</div>
				
				<ul class="settings" id="setting-tabs" role="tablist">
				
					<li class="settings-item reports">
						<a class="nav-link active" id="home-tab" href="{{route('reports.bulk.disbursement.index')}}">
							
							<i class="fas fa-3x fa-sign-out-alt"></i>
							<p class="title text-center mt-2">Bulk Disbursements</p>
						</a>
						
					</li>
					
			</div>
		</div>

	</div>
@endsection