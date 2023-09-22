@extends('frontend.layout.header')
@section('css')
<link href="{{asset('/frontend/css/dashboard.css')}}" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-outer text-center">
    <div class="container">
        <div class="breadcrumb-content">
            <h2>Dashboard</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    @if ($data->type === 'Purchase')
                    Purchase Details
                    @elseif ($data->type === 'Reservation')
                    Reservation Details
                    @endif
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="section-overlay"></div>
</section>
<section class="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 traffic">
                <div class="dashboard-list-box">
                    @if($data->type === 'Reservation')
                        <h4 class="gray mb-2">Reservation Details</h4>
                        <div class="card">
                        <div class="card-datatable p-2">
                                <table class="table dynamic_table font-weight-bold table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>First Name</td>
                                            <td>{{$data->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td>{{$data->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Number</td>
                                            <td>{{$data->order_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>{{$data->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{$data->status}}</td>
                                        </tr>
                                        <tr>
                                            <td>People</td>
                                            <td>{{$data->people}}</td>
                                        </tr>
                                        <tr>
                                            <td>Remarks</td>
                                            <td>{{$data->remarks}}</td>
                                        </tr>
                                        <tr>
                                            <td>Checkin Date Time</td>
                                            <td>{{$data->date}}<td>
                                        </tr>
                                        <tr>
                                            <td>Checkout Date Time</td>
                                            <td>{{$data->check_out_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Return Date Time</td>
                                            <td>{{$data->return_date_time}}</td>
                                        </tr>
                                        <tr>
                                            <td>Explain why customer did not stay or left without purchasing:</td>
                                            <td>{{$data->business_remarks}}</td>
                                        </tr>
                                        <tr>
                                            <td>How much customer spent:</td>
                                            <td>{{$data->customer_spent}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       @else
                        <h4 class="gray mb-2">Purchase Details</h4>
                         <div class="card">
                            <div class="card-datatable p-2">
                                <table class="table dynamic_table font-weight-bold table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>First Name</td>
                                            <td>{{$data->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td>{{$data->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Number</td>
                                            <td>{{$data->order_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>{{$data->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{$data->status}}</td>
                                        </tr>
                                        <tr>
                                            <td>Remarks</td>
                                            <td>{{$data->remarks}}</td>
                                        </tr>
                                        <tr>
                                            <td>Net Amount</td>
                                            <td>{{$data->net_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount Percentage</td>
                                            <td>{{$data->discount_percentage}}<td>
                                        </tr>
                                        <tr>
                                            <td>Discount Amount</td>
                                            <td>{{$data->discount_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount Code</td>
                                            <td>{{$data->discount_code}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Price</td>
                                            <td>{{$data->total_price}}</td>
                                        </tr>
                                        <tr>
                                            <td>Fee</td>
                                            <td>{{$data->fee}}</td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>{{$data->price}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Tickets</td>
                                            <td>{{$data->total_tickets}}</td>
                                        </tr>
                                        <tr>
                                            <td>Explain why customer did not stay or left without purchasing:</td>
                                            <td>{{$data->business_remarks}}</td>
                                        </tr>
                                        <tr>
                                            <td>How much customer spent:</td>
                                            <td>{{$data->customer_spent}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{asset('/frontend/js/dashboard-custom.js')}}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endsection
