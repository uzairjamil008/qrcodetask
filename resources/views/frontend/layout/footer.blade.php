<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<footer>

    <div class="footer-upper">

        <div class="container">

            <div class="newsletter text-center">

                <div class="section-title section-title-white text-center">

                    <h2>Newsletter Signup</h2>

                    <div class="section-icon section-icon-white">

                        <i class="flaticon-diamond"></i>

                    </div>

                    <p>Subscribe to our weekly newsletter to get updated on our latest deals</p>

                </div>

                <form class="sub-formdata">

                    {{ csrf_field() }}

                    <!-- <input type="hidden" class="form-control" name="id"> -->

                    <div class="form-group">

                        <input type="email" name="email" id="email" class="form-control" required>

                        <button id="submit_btn" type="submit"><span class="search_btn text-white"><i
                                    class="fa fa-paper-plane" aria-hidden="true"></i> Subscribe</span></button>

                    </div>

                </form>

            </div>

            <div class="footer-links">

                <div class="row">

                    <div class="col-lg-3">

                        <div class="footer-about footer-margin">

                            <div class="about-logo">

                                <a href="{{url('/')}}"><img class="latest-logo-footer"
                                        src="{{asset(get_settings('logo'))}}" width="126" height="58" alt="Image"></a>

                            </div>

                            <p></p>

                            <div class="about-location">

                                <ul>

                                    <!-- <li><i class="flaticon-maps-and-flags" aria-hidden="true"></i>Location</li>

                                        <p>Empire Mindz LLC<br>

                                           300 Park Avenue<br>

                                           New York, NY 10022</p> -->

                                    <!-- <li><i class="flaticon-phone-call"></i> (012)-345-6789</li>                                         -->

                                    <!-- <li><i class="flaticon-mail"></i> info@themaxhype.com</li> -->

                                </ul>

                            </div>

                            <div class="footer-social-links">

                                <ul>

                                    <li class="social-icon"><a href="https://www.facebook.com/people/Themaxhyped-Ent/61551836151376/"><i
                                                class="fa fa-facebook" aria-hidden="true"></i></a></li>

                                    <li class="social-icon"><a
                                            href="https://www.instagram.com/themaxhyped/?igshid=NTc4MTIwNjQ2YQ%3D%3D"><i
                                                class="fa fa-instagram" aria-hidden="true"></i></a></li>

                                    <li class="social-icon"><a href="https://twitter.com/TheMaxHype1"><i
                                                class="fa fa-twitter" aria-hidden="true"></i></a></li>

                                    <li class="social-icon"><a
                                            href="https://www.linkedin.com/in/themaxhype-maxhype-a05687199"><i
                                                class="fa fa-linkedin" aria-hidden="true"></i></a></li>

                                    <li class="social-icon"><a href="#"><i class="fa fa-google"
                                                aria-hidden="true"></i></a></li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="footer-links-list footer-margin">

                            <h3>THEMAXHYPED</h3>

                            <ul>

                                <li><a href="{{url('/testimonials')}}">Our Testimonals</a></li>

                                <li><a href="{{url('/privacypolicy')}}">Privacy Policy</a></li>

                                <li><a href="{{url('/terms')}}">Terms and Conditions</a></li>

                                <li><a href="{{url('/careers')}}">Careers</a></li>

                            </ul>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="footer-recent-post footer-margin">

                            <h3>MEMBERSHIP</h3>

                            <ul>

                                @php $membership = get_membership() @endphp

                                @foreach($membership as $key=>$value)

                                <li style="text-wrap: balance;"><a href="{{url('/bookings/'.$value->id)}}">{{$value->title}}</a></li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <div class="footer-links-list">

                            <div class="footer-instagram">

                                <h3>BUSINESESS</h3>

                                <ul>

                                    @php $business = get_business() @endphp

                                    @foreach($business as $value)

                                    <li><a href="{{url('business_details/'.$value-> id)}}"><img
                                                src="{{asset($value->dp) ?url('/').''.$value->dp:''}}" width="80"
                                                height="90" alt="Image"></a></li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="copyright">

        <div class="container">

            <div class="row">

                <div class="col-lg-6">

                    <div class="copyright-content">

                        <p>COPYRIGHT © 2023

                            <a class="ml-25" href="https://themaxhyped.com/" target="_blank">themaxhyped</a><span
                                class="d-none d-sm-inline-block">, All rights Reserved</span>
                        </P>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="payment-content">

                        <ul>

                            <li>We Accept</li>

                            <li>

                                <img src="{{asset('/frontend/images')}}/payment1.png" alt="Image">

                            </li>

                            <li>

                                <img src="{{asset('/frontend/images')}}/payment2.png" alt="Image">

                            </li>

                            <li>

                                <img src="{{asset('/frontend/images')}}/payment3.png" alt="Image">

                            </li>

                            <li>

                                <img src="{{asset('/frontend/images')}}/payment4.png" alt="Image">

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</footer>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {

    $(".sub-formdata").submit(function(e) {

        e.preventDefault();

        var token = $('input[name=_token]').val();
        $(".search_btn").attr("disabled", true).html('Processing...');

        var formdata = $(".sub-formdata").serialize();

        $.ajax({

            url: "{{url('/savesubscriber')}}",

            type: "POST",

            headers: {
                'X-CSRF-TOKEN': token
            },

            data: formdata,

            dataType: "json",

            success: function(data)

            {

                Swal.fire('You have Successfully Subscribed!')

                $('.sub-formdata')[0].reset();

                $(".search_btn").attr("disabled", false).html('Subscribe');


            }

        });

    });

});
</script>
