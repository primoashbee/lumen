@extends('layouts.user')
@section('content')
<div class="content pl-32 pl-64 pr-8 mt-4" id="content-full">
    <div class="{{$client}}">
      <update-client-form client="{{$client}}"></update-client-form>
    </div>
</div>
@endsection

@section('scripts')
<script>

</script>

@endsection