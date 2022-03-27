@extends('backend.layouts.app')
@section('head-tag')
  <title>{{env('APP_NAME')}} | Home</title>  
  <link rel="stylesheet" href="{{asset('backend/css/responsive.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('backend/css/buttons.bootstrap4.min.css')}}"/>
  <style type="text/css">
    .error{
            color:red;
        }
  </style>
@endsection

{{-- Main page content strarts here --}}
@section('content')
    
    <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 1342.88px;">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>
          
          <!-- Main content -->
          <section class="content">

            <div class="container-fluid">
              @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
              @endif
           
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form id="settings" class="settings" action="{{url('admin/settings/store')}}" method="post" enctype='multipart/form-data'>
                        @csrf
                       
                        <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label>Name<small class="text-danger">*</small></label>
                                <input type="text" name="name" class="form-control @error('name', 'settings') is-invalid @enderror" placeholder="Enter the Name" value="{{$getdata->name ?? ''}}">
                               </div>
                             </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Type<small class="text-danger">*</small></label>
                              <select name="type" class="form-control @error('type', 'settings') is-invalid @enderror" id="field_type" required="">
                                
                                  <option @if(isset($getdata->type) && $getdata->type == 'Text') selected @endif>Text</option>
                                  <option @if(isset($getdata->type) && $getdata->type == 'File') selected @endif>File</option>
                                </select>
                            </div>
                            </div>
                          <div class="col-md-4">
                             
                             <div class="form-group" id="actions">
                              <label>Staus<small class="text-danger">*</small></label>
                              <select name="status" class="form-control" id="status">
                          
                                <option @if(isset($getdata->status) && $getdata->status == 'Active') selected @endif>Active</option>
                                <option @if(isset($getdata->status) && $getdata->status == 'Inactive') selected @endif>Inactive</option>

                                
                                </select>
                            </div>
                          </div>
                            
                          <div class="col-md-12">
                              <div class="form-group field_name">
                                <label>Value<small class="text-danger">*</small></label>
                                <textarea class="form-control" name="value" id="field_name"  required="">
                                   @if(isset($getdata->type) && $getdata->type == 'Text'){{$getdata->value ?? ''}}@endif
                              </textarea>
                               </div>
                               <div class="form-group field_value" id="actions">
                              <label>value<small class="text-danger">*</small></label><br>
                              @if(isset($getdata->type) && $getdata->type == 'File')
                              <img src="{{asset('/backend/img/settings/value/'.$getdata->value)}}" height="100px">
                              @endif

                              <input type="file" name="file" class="form-control" id="field_value" value="{{$getdata->value ?? ''}}">
                            </div>
                              </div> 
                            </div>
                          </div>
                          <div class="submit-section col-md-12 text-center mt-5 form-control">
                               <input type="hidden" name="hdn_settimg_id" id="hdn_blog_id" value="{{$getdata->id ?? ''}}">
                            <button type="submit" class="btn btn-primary submit-btn" id="add_setting_submit">Submit</button>
                          </div>

                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div> 
  <!-- /.content-wrapper -->



@endsection
{{-- Main page content ends here --}}
@section('custom-script')
<script src="{{asset('backend/js/toastr.min.js')}}"></script>
<script src="{{asset('backend/js/jquery.validate.js')}}"></script>
<script src="{{asset('backend/js/additional-methods.min.js')}}"></script>
<script type="text/javascript">
 $(function () {
    // Summernote
    $('#field_name').summernote()
  })




//  $(function() {
//     $('.field_value').hide(); 
//     $('#field_type').change(function(){
//       var ty=$('#field_type').val();

//         if($('#field_type').val() == 'file') {
//           $('.field_name').hide();
//             $('.field_value').show(); 
//         } else {
//           $('.field_name').show();
//             $('.field_value').hide(); 
//         } 
//     });
// });


$(function(){
 
 var ty=$('#field_type').val();
 if(ty == 'Text')
 {
  $('#field_type').change(function(){
    var type=$('#field_type').val();
    if(type == 'File')
    { 
      $('.field_value').show();
      $('.field_name').hide(); 
    }
    else
    {
       $('.field_value').hide();
       $('.field_name').show(); 

    }

  })
   $('.field_value').hide();
    $('.field_name').show(); 
 }
 else
 {
    $('#field_type').change(function(){
    var type=$('#field_type').val();
    if(type == 'Text')
    { 
      $('.field_value').hide();
      $('.field_name').show(); 
    }
    else
    {
       $('.field_value').show();
       $('.field_name').hide(); 

    }

  })
  $('.field_value').show();
    $('.field_name').hide(); 
 }
 
})

</script>



@endsection
