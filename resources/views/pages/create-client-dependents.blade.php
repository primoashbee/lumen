@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
    <create-client-dependents id="{{$id}}" civil_status="{{$civil_status}}"></create-client-dependents>
</div>

@endsection