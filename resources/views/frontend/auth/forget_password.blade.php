@extends('frontend.layout.header')
@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-outer text-center">
    <div class="container">
        <div class="breadcrumb-content">
            <h2>Forgot Password</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/auth')}}">Login</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="section-overlay"></div>
</section>
<!-- BreadCrumb Ends -->

<!-- Forgot Password -->
<div class="forgot-password">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="fp-content">
                    <p>Please provide your email address. Click in the provided link to retrieve you account.</p>
                    <form id="forgotCutomerPassword">
                        {{ csrf_field() }}
                        @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Enter Email Address</label>
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="Name"
                                    placeholder="Enter username or email id">
                            </div>
                            <div class="col-lg-12">
                                <div class="comment-btn">
                                    <button type="submit" class="btn-blue btn-red">Send Email Links</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Ends -->

@endsection
@section('js')
<script>
$(document).on("submit", "#forgotCutomerPassword", function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: 'POST',
        url: "{{route('password.email')}}",
        data: data,
        success: function(response) {
            Swal.fire("kindly check your email for reset password");

        }
    });
});
</script>
@endsection