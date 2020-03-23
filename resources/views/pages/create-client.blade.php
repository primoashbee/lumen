@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
    <div class="">
      <create-client-form></create-client-form>

    </div>
   </div>
@endsection

@section('scripts')
<script>
    // window.addEventListener('load', function() {
    //     document.getElementById('gender').value = '{{old('gender')}}'
    //     document.getElementById('civil_status').value = '{{old('civil_status')}}'
    //     document.getElementById('education').value = '{{old('education')}}'
    //     document.getElementById('house_type').value = '{{old('house_type')}}'
    //     document.getElementById('house_type').value = '{{old('house_type')}}'
    // })    
</script>
@endsection