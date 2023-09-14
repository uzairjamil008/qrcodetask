<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

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
<strong>Date & Time</strong> : {{$data['date']}}</p>
<h5>You made Reservation from {{$data['business']->name}},<br>
Located at {{$data['cities']->location_city_name}} {{$data['country']->location_country_name}}, <br>
Address : {{$data['business']->address}}.<br>
For more details please contact to {{$data['business']->email}}.
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
<strong>Total Tickets</strong>: {{$data['total_tickets']}}<br>
<strong>Total Price</strong>: {{$data['net_amount']}}<br>
<h5>You made Purchase from {{$data['business']->name}},<br>
Located at {{$data['cities']->location_city_name}} {{$data['country']->location_country_name}}, <br>
Address : {{$data['business']->address}}.<br>
For more details please contact to {{$data['business']->email}}.
</h5>
@endif


</body>
</html>
