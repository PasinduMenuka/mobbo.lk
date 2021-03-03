@extends('shared.base')

@section('title', 'Contact Us')

@section('content')
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="contact">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>CONTACT US</h1>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->
<section class="section-margin--small">
    <div class="container">
        @if($data['settings'])

        <input type="hidden" id="latitude" value="{{$data['settings']->latitude ? $data['settings']->latitude : null}}">
        <input type="hidden" id="longitude"
               value="{{$data['settings']->longitude ? $data['settings']->longitude : null}}">

        @endif

        <div class="d-none d-sm-block mb-5 pb-4">
            <div id="map" style="height: 420px;"></div>
            <script>
                function initMap() {
                    var grayStyles = [
                        {
                            featureType: "all",
                            stylers: [
                                {saturation: -90},
                                {lightness: 50}
                            ]
                        },
                        {elementType: 'labels.text.fill', stylers: [{color: '#A3A3A3'}]}
                    ];
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {
                            lat: $('#latitude').val() ? $('#latitude').val() : -31.197,
                            lng: $('#longitude').val() ? $('#longitude').val() : 150.744
                        },
                        zoom: 9,
                        styles: grayStyles,
                        scrollwheel: false
                    });
                }

            </script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMku-pGW86pPGc__eKRpJ8-NolKmSHdRg&callback=initMap"
                async defer></script>

        </div>


        <div class="row" style="margin-top: 24px; margin-bottom: 24px">
            @if($data['settings'])

            <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
                <div class="media contact-info d-inline-flex">
                    <span class="contact-info__icon">
                        <i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    <div class="media-body">
                        <h3>{{$data['settings']->shop_name}}</h3>

                        @if($data['settings']->address_line_1)
                        <p>
                            {{$data['settings']->address_line_1}}
                            @if($data['settings']->address_line_2)
                            , {{$data['settings']->address_line_2}}

                            @endif

                            @if($data['settings']->address_line_3)
                            , {{$data['settings']->address_line_3}}

                            @endif

                            @if($data['settings']->address_line_4)
                            , {{$data['settings']->address_line_4}}

                            @endif
                        </p>
                        @endif
                    </div>
                </div>
                @if($data['settings']->hotline)
                <div class="media contact-info  d-inline-flex">
                    <span class="contact-info__icon"><i class="fa fa-headphones" aria-hidden="true"></i></span>
                    <div class="media-body">
                        <h3><a href="tel:{{$data['settings']->hotline}}">{{$data['settings']->hotline}}</a></h3>
                    </div>
                </div>
                @endif
                @if($data['settings']->email)
                <div class="media contact-info  d-inline-flex">
                    <span class="contact-info__icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <div class="media-body">
                        <h3><a href="mailto:support@colorlib.com">{{$data['settings']->email}}</a></h3>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <div class="col-md-8 col-lg-9">
                <form class="form-contact contact_form" action="{{route('Email')}}" method="post"
                      id="contactForm" novalidate="novalidate">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <input class="form-control" name="name" id="name" type="text"
                                       placeholder="Enter your name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" id="email" type="email"
                                       placeholder="Enter email address">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text"
                                       placeholder="Enter Subject">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <textarea class="form-control different-control w-100" name="message" id="message"
                                          cols="30" rows="5" placeholder="Enter Message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center pull-right">
                        <button type="submit" class="button button--active button-contactForm">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
