@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
	<form class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/settings">Settings</a></li>
						<li class="breadcrumb-item active" aria-current="page">List</li>
						</ol>
					</nav>
					<h3 class="h3">{{ucwords(str_replace("_"," ",$level))}} List</h3>
				</div>
				<div class="card-body">
					<office-list level="{{$level}}" list_level="{{$list_level}}"></office-list>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection