@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
	<create-office list_level="{{$list_level}}" level="{{$level}}"></create-office>
</div>

@endsection