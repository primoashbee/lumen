@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))


@section('scripts')
<script>
    setTimeout(()=>{
        location.href="{{route('client.list')}}"
    },2000)
</script>
    
@endsection
