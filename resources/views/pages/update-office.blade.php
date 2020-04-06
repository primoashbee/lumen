@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
    <update-office office="{{$office}}" list_level="{{$list_level}}"></update-office>
</div>
@endsection