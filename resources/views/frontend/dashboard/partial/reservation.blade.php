<table class="basic-table table-hover table-responsive">
         <thead>
            <tr role="row">
               <th>ID</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Checkin Data Time</th>
               <th>Checkout Date Time</th>
               <th>Special Notes</th>
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
               <td>{{$value->people}}</td>
               <td>{{$value->status}}</td>
               <td>{{$value->business_remarks}}</td>
               <td>{{$value->customer_spent}}</td>
               @if(Auth::user()->id==$value->business_id)
               @if($data['type'] =='business')
               <td class="dsdsdsdsad mt-2" style="display: flex;">
                 <a href="javascript:void(0)" class="button bg-primary add-reservation mr-1" data-id="{{$value->id}}" data-user="{{$value->business_id}}">Add Additional Remarks</a>
             </td>
             @endif
             @endif
            </tr>
            @endforeach
        </tbody>
</table>
