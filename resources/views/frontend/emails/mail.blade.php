<h3>Hi {{$data['first_name']}} {{$data['last_name']}},</h3>
<h5>We just received your {{$data['type']}} request.<br>
Thanks for your {{$data['type']}} ! You'll find a summary of your recent {{$data['type']}} bellow.</h5>
@if($data['type']=='Reservation')
<div class="row">
<span style="float: right; margin-right:60px;">{{$data['qr_code']}}</span>
</div>
<p><strong>Order #</strong> : {{$data['order_number']}}<br>
<strong>First Name</strong> : {{$data['first_name']}}<br>
<strong>Last Name</strong>: {{$data['last_name']}}<br>
<strong>Special Notes</strong> : {{$data['remarks']}}<br>
<strong>Number of people</strong> : {{$data['people']}}<br>
<strong>Checkin Date & Time</strong> : {{$data['date']}}<br>
@if(isset($data['check_out_date']))
    <strong>Checkout Date & Time</strong>: {{ $data['check_out_date'] }}
</p>
@endif
<h5>You made Reservation from {{$data['business']['name']}},<br>
Located at {{$data['cities']['location_city_name']}} {{$data['country']['location_country_name']}}, <br>
Address : {{$data['business_address']}}.<br>
For more details please contact to {{$data['business']['email']}}.
</h5>
@endif
@if($data['type']=='Purchase')
<div class="row">
<span style="float: right; margin-right:60px;">{{$data['qr_code']}}</span>
</div>
<p><strong>Order #</strong> : {{$data['order_number']}}<br>
<strong>First Name</strong> : {{$data['first_name']}}<br>
<strong>Last Name</strong> : {{$data['last_name']}}<br>
<strong>Special Notes</strong> : {{$data['remarks']}}<br>
<strong>Price</strong> : {{$data['price']}}<br>
<strong>Fee</strong> : {{$data['fee']}}<br>
<strong>Total Tickets</strong>: {{$data['total_tickets']}}<br>
<strong>Total Price</strong>: {{$data['total_price']}}<br>
<strong>Discount Code</strong>: {{$data['discount_code']}}<br>
<strong>Discount Amount</strong>: {{$data['discount_amount']}}<br>
<strong>Discount Percentage</strong>: {{$data['discount_percentage']}}<br>
<strong>Net Amount</strong>: {{$data['net_amount']}}<br>
<h5>You made Purchase from {{$data['business']['name']}},<br>
Located at {{$data['cities']['location_city_name']}} {{$data['country']['location_country_name']}}, <br>
Address : {{$data['business_address']}}.<br>
For more details please contact to {{$data['business']['email']}}.
</h5>
@endif
