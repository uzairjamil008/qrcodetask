<table class="basic-table table-hover table-responsive">
         <thead>
            <tr role="row">
               <th>Sr No</th>
               <th>First Name</th>
               <th>Last Name</th>
               <th>Special Notes</th>
               <th>Total Tickets</th>
               <th>Price</th>
               <th>Fee</th>
               <th>Total Price</th>
               <th>Discount Code</th>
               <th>Discount Amount</th>
               <th>Discount Percentage</th>
               <th>Net Amount</th>
               <th>Status</th>
               <th>Business Remarks</th>
               <th>Customer Spent</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($data['purchase'] as $key=>$value)
            <tr class="current-row">
               <td>{{$key+1}}</td>
               <td>{{$value->first_name}}</td>
               <td>{{$value->last_name}}</td>
               <td>{{$value->remarks}}</td>
               <td>{{$value->total_tickets}}</td>
               <td>{{$value->price}}</td>
               <td>{{$value->fee}}</td>
               <td>{{$value->total_price}}</td>
               <td>{{$value->discount_code}}</td>
               <td>{{$value->discount_amount}}</td>
               <td>{{$value->discount_percentage}}</td>
               <td>{{$value->net_amount}}</td>
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
