<table class="basic-table table-hover table-responsive custom-table">
         <thead>
            <tr role="row">
               <th>ID</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Checkin Data Time</th>
               <th>Checkout Date Time</th>
               <th>Special Notes</th>
               <th>Order Number</th>
               <th>Number of People</th>
               <th>Status</th>
               <th>Business Remarks</th>
               <th>Customer Spent</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($data['reservation'] as $key=>$value)
            <tr class="current-row">
               <td>{{$value->id}}</td>
               <td>{{$value->first_name}}</td>
               <td>{{$value->last_name}}</td>
               <td>{{$value->date}}</td>
               <td>{{$value->check_out_date}}</td>
               <td>{{$value->remarks}}</td>
               <td>{{$value->order_number}}</td>
               <td>{{$value->people}}</td>
               <td>{{$value->status}}</td>
               <td>{{$value->business_remarks}}</td>
               <td>{{$value->customer_spent}}</td>
               @if(Auth::user()->id==$value->business_id)
               @if($data['type'] =='business')
               <td>
                 <a href="javascript:void(0)" class="button bg-primary add-reservation mr-1" data-id="{{$value->id}}" data-user="{{$value->business_id}}" style="padding: 6px;">Add Remarks</a>
                 <a href="{{url('/details', ['type' => 'reservation', 'id' => $value->id])}}" class="button bg-primary">Detail</a>
               </td>
             @endif
             @endif
            </tr>
            @endforeach
        </tbody>
</table>
