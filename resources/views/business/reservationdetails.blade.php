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
               <table class="table dynamic_table font-weight-bold table-bordered">
                  <tbody>
                     <tr>
                        <td>First Name</td>
                        <td>{{$data['results']->first_name}}</td>
                     </tr>
                     <tr>
                        <td>Last Name</td>
                        <td>{{$data['results']->last_name}}</td>
                     </tr>
                     <tr>
                        <td>Order Number</td>
                        <td>{{$data['results']->order_number}}</td>
                     </tr>
                     <tr>
                        <td>Type</td>
                        <td>{{$data['results']->type}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>{{$data['results']->status}}</td>
                     </tr>
                     <tr>
                        <td>People</td>
                        <td>{{$data['results']->people}}</td>
                     </tr>
                     <tr>
                        <td>Remarks</td>
                        <td>{{$data['results']->remarks}}</td>
                     </tr>
                     <tr>
                        <td>Checkin Date Time</td>
                        <td>{{$data['results']->date}}<td>
                     </tr>
                     <tr>
                        <td>Checkout Date Time</td>
                        <td>{{$data['results']->check_out_date}}</td>
                     </tr>
                     <tr>
                        <td>Return Date Time</td>
                        <td>{{$data['results']->return_date_time}}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">
<script type="text/javascript">
   $('.dynamic_table').DataTable();
</script>
@endsection
