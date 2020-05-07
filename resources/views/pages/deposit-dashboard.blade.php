@extends('layouts.user')

@section('content')

<div class="content pl-32 pr-8 mt-4" id="content-full">
	<div class="row">
		<div class="col-lg-12">
		
			<deposit-dashboard :account_id="{{$account->id}}" :account_info="{{$account}}"></deposit-dashboard>
		</div>
	</div>
</div>

@endsection