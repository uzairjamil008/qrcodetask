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
            </div>
            <div class="card-datatable p-2">
               <table class="table dynamic_table font-weight-bold">
                  <thead>
                     <tr role="row">
                        <th>ID</th>
                        <th>Business Name</th>
                        <th>Check in Date Time</th>
                        <th>Checkout Date Time</th>
                        <th>Return Date Time</th>
                        <th>Remarks</th>
                        <th>Number Of People</th>
                        <th>Remarks</th>
                        <th>Action</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myreservationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Save</h3>
            <button type="button" class="close" id="close-modal" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{url('save_data')}}" method="post">
               @csrf
               <input name="business_reservation_id" type='hidden'>
               <div class="form-group">
                  <label for="remarks">Remarks:</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" name="admin_notes" rows="3"></textarea>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@include('includes.delete')
@endsection
@section('js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">

<script type="text/javascript">
   $('.business-request').addClass('sidebar-group-active');
   $(document).on('click', '.remarksbtn', function() {
      var id = $(this).attr('data-id');
      $('input[name=business_reservation_id]').val(id);
      $('#myreservationModal').modal('show');
   });
   $(document).ready(function() {
      $('.reserve-business').addClass('active');
      var userInfo = JSON.parse(localStorage.getItem("userInfo"));

      $('.dynamic_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{url('admin/get_reservation')}}",
         columns: [{
               data: 'id'
            },
            {
               data: 'business_id'
            },
            {
               data: 'date'
            },
            {
               data: 'check_out_date'
            },
            {
               data: 'return_date_time'
            },
            {
               data: 'remarks'
            },
            {
               data: 'people'
            },
            {
               data: 'admin_notes'
            },
            {
               data: 'action'
            },
         ],
         'columnDefs': [{
            'targets': [8],
            'orderable': false,
         }]
      });

      $('.dynamic_table').on('draw.dt', function() {
         feather.replace();
      });

   });
</script>

@endsection