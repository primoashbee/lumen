<template>
	<div class="row setting-wrapper">
			<div class="col-lg-9 pr-0 setting-container">
				<div class="row">
					<div class="filters-container d-inline-block mb-4 col-md-6">
						<h4 class="h4 d-inline-block">Filter:</h4>
						<div class="btn-filter-group ml-4 d-inline-block">
							<button data-filter="*" class="btn-filters">Show All</button>
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
					<li class="settings-item metal">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-sitemap"></i>
							<p class="title text-center mt-2">Structure</p>
						</a>
						
					</li>
					
					<li class="settings-item user">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-users"></i>
							<p class="title text-center mt-2">Users</p>
						</a>
						
					</li>
					<li class="settings-item user">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-user-tag"></i>
							<p class="title text-center mt-2">Role</p>
						</a>
						
						
					</li>
					<li class="settings-item loans">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-sign-out-alt"></i>
							<p class="title text-center mt-2">Loan</p>
						</a>
						
					</li>
					<li class="settings-item deposit">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-sign-in-alt"></i>
							<p class="title text-center mt-2">Deposit</p>
						</a>
					</li>
					<li class="settings-item loans">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-credit-card"></i>
							<p class="title text-center mt-2">Fees</p>
						</a>
						
						
					</li>
					<li class="settings-item loans">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-flag"></i>
							<p class="title text-center mt-2">Holidays</p>
						</a>
						
						
					</li>
					<li class="settings-item reports">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-calculator"></i>
							<p class="title text-center mt-2">Accounting</p>
						</a>
						
						
					</li>
					<li class="settings-item reports">
						<a class="nav-link active" id="home-tab" href="">
							<i class="fas fa-3x fa-file"></i>
							<p class="title text-center mt-2">Reports</p>
						</a>
						
					</li>
					<li class="settings-item reports">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-file-alt"></i>
							<p class="title text-center mt-2">Dynamic Reports</p>
						</a>
						
						
					</li>
					<li class="settings-item">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-hands-helping"></i>
							<p class="title text-center mt-2">Transactions</p>
						</a>
						
						
					</li>
					<li class="settings-item">
						<a class="nav-link" id="home-tab" href="">
							<i class="fas fa-3x fa-sitemap"></i>
							<p class="title text-center mt-2">Templates</p>
						</a>
						
						
					</li>
				</ul>

			</div>
		</div>
</template>

<script type="text/javascript">
	export default{

		
	}

</script>