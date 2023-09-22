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
                        <td>Remarks</td>
                        <td>{{$data['results']->remarks}}</td>
                     </tr>
                     <tr>
                        <td>Net Amount</td>
                        <td>{{$data['results']->net_amount}}</td>
                     </tr>
                     <tr>
                        <td>Discount Percentage</td>
                        <td>{{$data['results']->discount_percentage}}<td>
                     </tr>
                     <tr>
                        <td>Discount Amount</td>
                        <td>{{$data['results']->discount_amount}}</td>
                     </tr>
                     <tr>
                        <td>Discount Code</td>
                        <td>{{$data['results']->discount_code}}</td>
                     </tr>
                     <tr>
                        <td>Total Price</td>
                        <td>{{$data['results']->total_price}}</td>
                     </tr>
                     <tr>
                        <td>Fee</td>
                        <td>{{$data['results']->fee}}</td>
                     </tr>
                     <tr>
                        <td>Price</td>
                        <td>{{$data['results']->price}}</td>
                     </tr>
                     <tr>
                        <td>Total Tickets</td>
                        <td>{{$data['results']->total_tickets}}</td>
                     </tr>
                     <tr>
                        <td>Explain why customer did not stay or left without purchasing:</td>
                        <td>{{$data['results']->business_remarks}}</td>
                     </tr>
                     <tr>
                        <td>How much customer spent:</td>
                        <td>{{$data['results']->customer_spent}}</td>
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
