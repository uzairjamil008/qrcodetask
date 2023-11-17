@extends('frontend.layout.header')
@section('css')
<link href="{{asset('/frontend/css/stripe.css')}}" rel="stylesheet" type="text/css">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<link href="{{asset('/frontend/css/bootstrap-timepicker.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-outer text-center">
    <div class="container">
        <div class="breadcrumb-content">
            <h2>{{$data['type']}}</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb reservation-crumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/businesses/'.$data['details']->businesses->type)}}">{{$data['details']->businesses->type}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/business_details/'.$data['details']->businesses->id)}}">{{$data['details']->businesses->name}} Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$data['type']}}</li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="section-overlay"></div>
</section>
<!-- BreadCrumb Ends -->
<section class="booking">
    <div class="container justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-12">
                <div class="booking-form booking-outer">
                    <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}" required readonly>

                    <h3 class="">Enter The Following Information For {{$data['type']}}</h3>
                    @if($data['type']=="Purchase")
                    <input type="hidden" name="availeble_tickets" value="{{get_availability_tickets($data['total_tickets'],$data['id'])}}" class="test-availeble-tickets">
                    @else
                    <input type="hidden" name="availeble_tickets" value="{{get_availability($data['total_tickets'],$data['id'])}}" class="test-availeble-tickets">
                    @endif
                    <form class="formdata" id="reserve-form" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="business_id" value="{{$data['details']->businesses->id}}" class="form-control">
                        <input type="hidden" name="customer_id" value="{{Auth::user()->id}}" class="form-control">
                        <input type="hidden" name="product_id" value="{{$data['id']}}" class="form-control">
                        <input type="hidden" name="type" value="{{$data['type']}}" class="form-control">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <br>
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{Auth::user()->first_name}}" required readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <br>
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{Auth::user()->last_name}}" required readonly>
                            </div>
                        </div>
                        @if($data['type']=='Reservation')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table_item">
                                    <div class="form-group">
                                        <label>Check In Date Time</label>
                                        <div class="input-group date">
                                            <input type="datetime-local" name="date" id="checkInDate" class="form-control" required>
                                            <i class="flaticon-calendar"></i>
                                            <!-- <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- @if ($data['is_return'] == 0)
                        <div class="form-group col-md-6">
                            <label>Checkout Date Time</label>
                            <input type="datetime-local" name="check_out_date" class="form-control" required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label>Return Date Time</label>
                            <input type="datetime-local"  name="return_date_time" class="form-control" required>
                        </div>
                        @endif -->
                            <!-- </div> -->
                            @if($data['business_type']=='Vehicles-ATV-Bikes-Boats-JetSkis' || $data['business_type']=='Afrobeats' || $data['business_type']=='Movie Theaters & Adventures')
                            <!-- <div class="row"> -->
                            <div class="col-md-6">
                                <div class="table_item">
                                    <div class="form-group">
                                        <label>Check Out Date Time</label>
                                        <input type="datetime-local" name="check_out_date" id="checkOutDate" class="form-control" required>
                                        <!-- <div class="input-group date" id="datetimepicker1">
                                            <input type="text" name="return_date" class="form-control" value="dd-mm-yyyy" id="return-date" required>
                                            <i class="flaticon-calendar"></i>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>


                            @if ($data['is_return'] == 1)
                            <div class="form-group col-md-6">
                                <label>Return Date Time</label>
                                <input type="datetime-local" name="return_date_time" class="form-control" required>
                            </div>
                            @endif
                            <!-- <div class="form-group col-md-6">
                            <label>Return Time</label>
                            <input type="text" id="timepicker1" name="return_time" class="form-control" required>
                          </div> -->
                        </div>
                        @else
                        <div class="col-md-6"></div>
                </div>
                @endif

                @endif
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Special Notes</label>
                        <input type="text" placeholder="Add your notes" name="remarks" class="form-control">
                    </div>
                    @if($data['type']=='Reservation')
                    <div class="col-md-6">
                        <div class="form-group m-form__group">
                            <label>Number Of People</label>
                            <select name="people" id="select-people" class="form-control" required>
                                <option value="">Select</option>
                                <?php
                                for ($i = 1; $i <= 50; $i++) {
                                    echo "<option>{$i}</option>";
                                }
                                ?>
                                <!-- <option>1</option> -->
                            </select>
                        </div>
                    </div>
                    @endif
                    @if($data['type']=='Purchase')
                    <div class="col-md-6">
                        <div class="form-group m-form__group">
                            <label>Total Tickets</label>
                            <select name="total_tickets" id="select-tickets" class="form-control" required>
                                <option value="">Select</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Price</label>
                        <input type="text" class="form-control" name="price" value="{{$data['price']}}" required readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Fee</label>
                        <input type="text" class="form-control" id="fee" value="{{$data['fee']}}" name="fee" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Price</label>
                        <input type="text" placeholder="Total Price" class="form-control" name="total_price" id="total_price" required readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Discount Code</label>
                        <input type="text" id="discount-code" name="discount_code" placeholder="Enter Discount Code">
                        <button type="button" id="check-discount" class="btn btn-success btn-sm" style="margin-top: 10px;">Check Discount</button>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Discount Amount</label>
                        <input type="text" id="discount_amount" name="discount_amount" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="discount_percentage" id="discount_percentage">
                    <div class="form-group col-md-4">
                        <label>Net Amount</label>
                        <input type="text" id="net_amount" name="net_amount" class="form-control" readonly>
                    </div>
                </div>
                <!-- <div class="row">
                            <div class="form-group col-md-6">
                              <label for="card-element">
                               Credit Card
                               </label>
                               <div id="card-element" class="form-control" style="height: 40px; line-height: 40px; font-weight: bold; font-size: 16px;">
                              A Stripe Element will be inserted here.
                                </div>
                           Used to display form errors.
                              <div id="card-errors" role="alert" class="red-color" style="margin-top: 5px;"></div>
                            </div>
                        </div> -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="card-element">
                            Card Number
                        </label>
                        <input type="text" name="card_number" class="form-control" value="{{(isset($data['card_data']->card_number) ? $data['card_data']->card_number : '')}}" required>
                        <!-- <div id="card-element" class="form-control" style="height: 40px; line-height: 40px; font-weight: bold; font-size: 16px;"> -->
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <div class="form-group col-md-4">
                        <label for="card-element">
                            Expiry
                        </label>
                        <input type="text" name="expiry" placeholder="MM/YY" class="form-control" value="{{(isset($data['card_data']->expiry) ? $data['card_data']->expiry : '')}}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="card-element">
                            Cvc
                        </label>
                        <input type="text" name="cvc" placeholder="Enter digits back on your card" class="form-control" value="{{(isset($data['card_data']->cvc) ? $data['card_data']->cvc : '')}}" required>
                    </div>
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert" class="red-color" style="margin-top: 5px;"></div>
                </div>
                @endif
                <div class="row">
                    <div class="col-xs-12">
                        <div class="comment-btn">
                            <button id="btn-reserve" class="btn-blue btn-red" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="{{asset('/frontend/js/bootstrap-timepicker.js')}}"></script>
<script type="text/javascript">
    // validation for card number
    //check if card number exist
    if ($('input[name=card_number]').length > 0) {

        var cardNumberInput = document.querySelector('input[name=card_number]');
        cardNumberInput.addEventListener('input', function(e) {
            var cardNumber = e.target.value.replace(/\D/g, '');
            if (cardNumber.length > 16) {
                cardNumber = cardNumber.slice(0, 16);
            }
            e.target.value = cardNumber;
        });

        // validation of cvc
        var cvcInput = document.querySelector('input[name=cvc]');
        cvcInput.addEventListener('input', function(e) {
            var cvc = e.target.value.replace(/\D/g, '');
            if (cvc.length > 4) {
                cvc = cvc.slice(0, 4);
            }
            e.target.value = cvc;
        });

        // validation of expiry
        var expiryInput = document.querySelector('input[name=expiry]');
        expiryInput.addEventListener('input', function(e) {
            var expiry = e.target.value.replace(/\D/g, '');
            if (expiry.length >= 2) {
                var month = expiry.substring(0, 2);
                var year = expiry.substring(2, 4);
                if (year.length > 2) {
                    year = year.substring(0, 2);
                }

                expiry = month + '/' + year;
            }
            e.target.value = expiry;
        });
    }



    function applyDiscount(totelamount) {
        var discountCode = $('#discount-code').val();

        if (discountCode == '') {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "{{url('check_discount')}}",
            data: {
                _token: "{{ csrf_token() }}",
                discount_code: discountCode,
                amount: totelamount
            },
            success: function(response) {
                if (response.valid) {
                    $('#discount-code').addClass('readonly', true);
                    $('#check-discount').prop('disabled', true);
                    $('#discount_amount').val(response.discount_amount);
                    $('#net_amount').val(response.net_amount);
                    $('#discount_percentage').val(response.discount_percentage);
                } else {
                    alert("Discount Code is not Valid");
                }
            }
        });
    }
    $(document).ready(function() {

        $('#check-discount').click(function() {
            var discountCode = $('#discount-code').val();
            if (discountCode == '') {
                alert('Enter something in discount code');
                return false;
            }
            let tickets = $('select[name=total_tickets]').val();
            if (tickets == '') {
                alert('Select tickets first before applying discount');
                return false;
            }
            var totelamount = $('#total_price').val();
            applyDiscount(totelamount);
        });

    });
    $(document).ready(function() {
        $(document).on('submit', '#reserve-form', function(e) {
            e.preventDefault();
            var token = $('input[name=_token]').val();
            var date = $('input[name=date]').val();
            let type = $('input[name=type]').val();
            @if($data['type'] == 'Reservation')
            var return_date_time = $('input[name=return_date_time]').val();
            var people = $('select[name=people]').val();
            if (date == '') {
                alert('Please select the date.');
                return false;
            } else if (return_date_time == '') {
                alert('Please select the current date.');
                return false;
            } else if (people == '') {
                alert('Please select the number of people.');
                return false;
            }
            @else
            var tickets = $('select[name=total_tickets]').val();
            if (tickets == '') {
                alert('Please select the total tickets.');
                return false;
            }
            @endif
            // createPaymentIntent();


            $("#btn-reserve").attr("disabled", true).html('Processing...');
            var formdata = $('#reserve-form').serialize();
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: "{{url('/save_reservation')}}",
                dataType: "json",
                data: formdata,
                success: function(data) {
                    if (data.success) {
                        if (type == 'Purchase') {
                            Swal.fire('Great ! You have successfully Purchased.Please check your email for the details.')
                        } else {
                            Swal.fire('Great ! You have successfully Reserved.Please check your email for the details.')
                        }

                        $('#reserve-form')[0].reset();
                        $("#btn-reserve").attr("disabled", false).html('Submit');
                    } else {
                        $("#btn-reserve").attr("disabled", false).html('Submit');
                        Swal.fire(data.message);
                    }

                }
            });
        });

        $('#timepicker').timepicker({
            showPeriod: true,
            onHourShow: OnHourShowCallback,
            onMinuteShow: OnMinuteShowCallback
        });
        $('#timepicker1').timepicker({
            showPeriod: true,
            onHourShow: OnHourShowCallback,
            onMinuteShow: OnMinuteShowCallback
        });

        function OnHourShowCallback(hour) {
            if ((hour > 20) || (hour < 6)) {
                return false; // not valid
            }
            return true; // valid
        }

        function OnMinuteShowCallback(hour, minute) {
            if ((hour == 20) && (minute >= 30)) {
                return false;
            } // not valid
            if ((hour == 6) && (minute < 30)) {
                return false;
            } // not valid
            return true; // valid
        }
        $(document).on('change', 'select[name=people]', function() {
            var people = $(this).val();
            var available_tickets = parseFloat($('input[name=availeble_tickets]').val());
            if (people > available_tickets) {
                $("#select-people")[0].selectedIndex = 0;
                alert('Availeble tickets is less than the selected people, Please ! select a valid number of people');
            }
        });
        $(document).on('change', 'select[name=total_tickets]', function() {
            var total_tickets = $(this).find(":selected").text();
            var unit_price = $('input[name=price]').val();
            var fee = $('#fee').val();
            var total_price = (total_tickets * unit_price) + (+fee);
            $("input[name=total_price]").val(total_price);
            $('#net_amount').val(total_price);
            var available_tickets = parseFloat($('input[name=availeble_tickets]').val());

            applyDiscount(total_price);
            if (total_tickets > available_tickets) {
                $("#select-tickets")[0].selectedIndex = 0;
                alert('Availeble tickets is less than the selected total tickets, Please ! select a valid number of total tickets');
                $("#total_price").val('');
            }
        });
        //to set datepicker default current date
        $('#departure-date').datepicker({
            format: 'dd/mm/yyyy',
        }).datepicker("setDate", 'now');
        $('#return-date').datepicker({
            format: 'dd/mm/yyyy',
        }).datepicker("setDate", 'now');
    });

    // js for skip the previous date
    var today = new Date().toISOString().slice(0, 16);

    document.getElementsByName("date")[0].min = today;
    document.getElementsByName("check_out_date")[0].min = today;
    document.getElementsByName("return_date_time")[0].min = today;
    // end js

    const checkInDateInput = document.getElementById('checkInDate');
    const checkOutDateInput = document.getElementById('checkOutDate');
    const submitButton = document.getElementById('btn-reserve');

    checkInDateInput.addEventListener('change', function() {
        validateDates();
    });

    checkOutDateInput.addEventListener('change', function() {
        validateDates();
    });

    function validateDates() {
        const checkInDate = new Date(checkInDateInput.value);
        const checkOutDate = new Date(checkOutDateInput.value);

        if (checkOutDate < checkInDate) {
            alert('Please select a check-out date that is after the check-in date.');
            submitButton.disabled = true;
        } else {
            submitButton.disabled = false;
        }
    }
</script>
@endsection