
		<div class="sidebar" id="sidebar">
			<div class="sidebar-wrapper px-3">
				<div class="logo py-2">
					
					<a href="">
						<i class="fas fa-2x fa-lightbulb py-2"></i>
						<p class="text-lg">Lumen</p>
					</a>
					
				</div>

				<div class="sidebar-nav mt-8">
					<ul>
						<li class="{{ \Str::contains(request()->url(), 'dashboard') ? 'active' :'' }} py-2">
                            <a href="{{ route('dashboard') }}">
								<i class="fas fa-2x fa-chart-pie"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="{{ \Str::contains(request()->url(), 'client') ? 'active':'' }}py-2">
							<a href="{{ route('precreate.client') }}">
								<i class="fas fa-2x fa-plus-square"></i>
								<p>Create</p>
							</a>
						</li>
						<li class="{{ \Str::contains(request()->url(), 'client') ? 'active' :'' }}py-2">
							<a href="">
								<i class="fas fa-2x fa-user"></i>
								<p>Client</p>
							</a>
						</li>
						<li class="py-2">
							<a href="">
								<i class="fas fa-2x fa-users"></i>
								<p>Clusters</p>
							</a>
						</li>
						<li class="py-2">
							<a href="">
								<i class="far fa-2x fa-list-alt"></i>
								<p>Reports</p>
							</a>
						</li>
						<li class="py-2">
							<a href="">
								<i class="fas fa-2x fa-cogs"></i>
								<p>Administration</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>