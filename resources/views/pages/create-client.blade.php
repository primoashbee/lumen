@extends('layouts.user')
@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
    <div class="row">
        @csrf
       <div class="col-md-9">
         <div class="card">
               <div class="card-header">
                 <h3 class="h3 ml-3">Profile</h3>
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
                   
                <div  class="file-input-profile d-block text-center position-relative mb-4">
                  <img src="{{ asset('assets/img/default.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
                    <div class="file-input text-center">
                        <span class="position-relative btn btn-rose btn-round btn-file">
                            <span class="fileinput-new">Image</span>
                            <input value="{{ old('profile_picture_path') }}" type="file" class="attachment" name="profile_picture_path" id="profile_picture_path">
                            </span>
                    </div>
                  </div>
                  <div  class="file-input-signature d-block text-center position-relative">
                    <img src="{{ asset('assets/img/signature.png')}}" class="img-thumbnail" alt="Cinque Terre"> 
                      <div class="file-input text-center">
                          <span class="position-relative btn btn-rose btn-round btn-file">
                          <span class="fileinput-new">Signature</span>
                          <input value="{{ old('signature_path') }}" type="file" class="attachment" name="signature_path" id="signature_path">
                          </span>
                      </div>
                  </div>
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