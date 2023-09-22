<div class="panel panel-default panel-fill">
   <div class="panel-body">
      <div class="about-info-p">
         <strong>First Name</strong>
         <br>
         <p class="text-muted">{{$data['customer']->first_name}}</p>
      </div>
      <div class="about-info-p">
         <strong>Last Name</strong>
         <br>
         <p class="text-muted">{{$data['customer']->last_name}}</p>
      </div>
      <div class="about-info-p">
         <strong>Phone#</strong>
         <br>
         <p class="text-muted">{{$data['customer']->phone}}</p>
      </div>
      <div class="about-info-p">
         <strong>Email</strong>
         <br>
         <p class="text-muted">{{$data['customer']->email}}</p>
      </div>
      <div class="about-info-p m-b-0">
         <strong>Registeration Date &amp; Time</strong>
         <br>
         <p class="text-muted">{{$data['customer']->created_at}}</p>
      </div>
      <div class="about-info-p m-b-0">
         <strong>Customer Status</strong>
         <br>
         <p class="text-muted">{{$data['customer']->status}}</p>
      </div>
      <br>
      <h5>Card Details</h5>
      @if(empty($data['card_details']))
      <p>No Card Data Availabe</p>
      @else
      <div class="about-info-p m-b-0">
         <strong>Card Number</strong>
         <br>
         <p class="text-muted">{{$data['card_details']->card_number}}</p>
      </div>
      <div class="about-info-p m-b-0">
         <strong>Expiry</strong>
         <br>
         <p class="text-muted">{{$data['card_details']->expiry}}</p>
      </div>
      <div class="about-info-p m-b-0">
         <strong>Cvc</strong>
         <br>
         <p class="text-muted">{{$data['card_details']->cvc}}</p>
      </div>
      @endif
   </div>
</div>
