@extends('backend.layouts.app')
@section('head-tag')
  <title>{{env('APP_NAME')}} | Home</title>  
  <link rel="stylesheet" href="{{asset('backend/css/dataTables.bootstrap4.min.css')}}"/>
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
                  <h1>Setting</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>
                    <li class="breadcrumb-item active">Setting</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <!-- <h3 class="card-title">Blogs List</h3> -->
                      <div class="float-right">
                          <a href="{{url('admin/addsettings')}}" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i> Add Setting</a>
                      </div>
                    </div>
                    <div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Name</th>
                          <th>Value</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                        </thead>

                        <tbody> 
                          @foreach($settings as $settings)                      
                            <tr>
                              <td>{{$settings->name}}</td>
                              <!-- <td>{{$settings->value}}</td>  -->
                              <td>
                                @if($settings->name =='Image')
                                <img  src="{{ asset('/backend/img/settings/value/'.$settings->value) }}"style="width: 50px;height: 50px;">
                                @elseif($settings->name =='Music')
                               <audio controls>
                                <source src="{{ asset('/backend/img/settings/value/'.$settings->value)}}" type="audio/mpeg"> 
                                </audio>
                                @else
                                {{$settings->value}} </td>
                               @endif
                              <td>{{$settings->type}}</td>  
                              <td>
                                <span class="badge badge-{{$settings->status == 'Active' ? 'success' : 'danger'}}"></span>
                                {{$settings->status ?? ''}}
                              </td>                              
                              <td class="project-actions text-right" data-id="{{$settings->id}}">
                                <select name="status" class="Setting_status" id="Setting_status">
                                  <option value="Active" @if($settings->status == 'Active'){{'selected'}} @endif>Active</option>
                                  <option value="Inactive" @if($settings->status == 'Inactive'){{'selected'}} @endif>Inactive</option>
                                </select>
                                <a class="btn btn-info btn-xs update-settings" href="{{url('admin/settings/edit'.'/'.$settings->id)}}" title="Edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>                                    
                                </a>
                                <a class="btn btn-danger btn-xs delete-settings" data-id="{{$settings->id}}" href="javascript:void(0)" title="Delete">
                                    <i class="fas fa-trash">
                                    </i>                                    
                                </a>
                              </td>                         
                            </tr> 
                            @endforeach
                          
                          </tbody>
                      </table>
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
<script src="{{asset('backend/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/js/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/js/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/js/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/js/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/js/toastr.min.js')}}"></script>
<script src="{{asset('backend/js/jquery.validate.js')}}"></script>
<script src="{{asset('backend/js/additional-methods.min.js')}}"></script>
<script src="{{asset('backend/js/blogs/blogs.js')}}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $(".delete-settings").click(function(){
      var setting_id = $(this).attr('data-id');
      if (setting_id > 0) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/admin/setting/delete-setting',
            data: { 'id': setting_id },            
            success: function (response) {   
              toastr["success"](response.message);   
              var timer = setTimeout(function() {
                window.location.reload();
              }, 1000);              
            },
            error: function (error) {                
              toastr["error"]("Oops! Something Went Wrong ! Try Again <i class=\"fa fa-frown-o\" aria-hidden=\"true\"></i>");                            
            }
          });
      }
    });
  });

  $(document).ready(function(){
    $('.Setting_status').on('change', function() {
        var option = $(this).find('option:selected').val();
        var id = $(this).parent().attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
          type: 'POST',
          url: '/admin/settings/status',
          data: {'option': option, 'id' : id},
          success: function (response) {   
            toastr["success"](response.message);
            location.reload();    
          },
          error: function (error) {  
            toastr["error"]("Oops! Something Went Wrong ! Try Again <i class=\"fa fa-frown-o\" aria-hidden=\"true\"></i>");
          }
        });    
    });
  });
 
</script>>
@endsection
