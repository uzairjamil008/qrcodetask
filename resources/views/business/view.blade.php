@extends('layout.header')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/colors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
<section id="basic-datatable">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-header border-bottom">
               <h4 class="card-title">{{$data['page_title']}}</h4>
               <a class="btn btn-primary" href="{{url('admin/businesses')}}">Add Business</a>
            </div>
            <div class="card-datatable p-2">
               <table class="table dynamic_table font-weight-bold">
                  <thead>
                     <tr role="row">
                        <th>ID</th>
                        <th>Business Name</th>
                        <th>Email</th>
                        <th>Business Type</th>
                        <th>Action</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
@include('includes.delete')
@endsection
@section('js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">

<script type="text/javascript">
   $('.business-mgt').addClass('sidebar-group-active');
   $(document).ready(function() {
      $('.view-business').addClass('active');
      var userInfo = JSON.parse(localStorage.getItem("userInfo"));

      $('.dynamic_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{url('admin/get_business')}}",
         columns: [{
               data: 'id'
            },
            {
               data: 'name'
            },
            {
               data: 'email'
            },
            {
               data: 'type'
            },
            {
               data: 'action'
            },
         ],
         'columnDefs': [{
            'targets': [4],
            'orderable': false,
         }]
      });

      $('.dynamic_table').on('draw.dt', function() {
         feather.replace();
      });

   });
</script>

@endsection