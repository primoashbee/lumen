@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
    <div class="row">
        @csrf
       <div class="col-md-9">
         <div class="card">
               <div class="card-header">
                 <h3 class="h3 ml-4">Profile</h3>
               </div>
               <div class="card-body">
                    <create-client-form></create-client-form>
               </div>
         </div>
       </div>
       <div class="col-md-3">
           <div class="card">
               <div class="card-header">
                   <h4 class="text-center h4">Attachment</h4>
               </div>

               <div class="card-body">
                   
                <img src="{{ asset('assets/img/default.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
                <img src="{{ asset('assets/img/signature.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
               </div>
           </div>
       </div> 
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