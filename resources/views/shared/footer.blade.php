<!-- FOOTER -->
<footer class="footer-distributed">

    <div class="footer-left">
        @if($data['settings'])
        <h3>{{$data['settings']->shop_name}}</h3>
        @endif

        <p class="footer-links">
            <a href="/">Home</a> |
            @foreach($data['categories'] as $category)
            <a href="{{route('Store', $category->slug)}}">{{$category->name}} | </a>
            @endforeach
        </p>

        <p style="color:white;" class="footer-company-name"> Copyright &copy;<script>document.write(new Date().getFullYear());</script>
            All rights reserved | <i class="fa fa-heart-o" aria-hidden="true"></i> by 9xcoders (Pvt).Ltd <a
                style="color:goldenrod;" href="http://9xcoders.com" target="_blank">www.9xcoders.com</a></p>

    </div>

    @if($data['settings'])
    <div class="footer-center">

        <div>
            <i class="fa fa-map-marker"></i>
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

        <div>
            @if($data['settings']->hotline)
            <i class="fa fa-phone"></i>
            <p>{{$data['settings']->hotline}}</p>
            @endif
        </div>

        <div>
            @if($data['settings']->email)
            <i class="fa fa-envelope"></i>
            <p><a href="mailto:{{$data['settings']->email}}">{{$data['settings']->email}}</a></p>
            @endif
        </div>

    </div>

    @endif

    <div class="footer-right">

        <p class="footer-company-about">
            <span>About Us</span>
            We at Mobo.lk bring you the latest phones from all manufacturers to your hands with the best quality,
            customer service and unmatched warranty schemes. With numerous customer reviews on the best customer service
            out there Mobo.lk.
        </p>
        @if($data['settings'])
        <div class="footer-icons">

            @if($data['settings']->facebook_link)
            <a href="{{$data['settings']->facebook_link}}"><i class="fa fa-facebook"></i></a>
            @endif
            @if($data['settings']->instagram_link)
            <a href="{{$data['settings']->instagram_link}}"><i class="fa fa-instagram"></i></a>
            @endif
            @if($data['settings']->twitter_link)
            <a href="{{$data['settings']->twitter_link}}"><i class="fa fa-twitter"></i></a>
            @endif
            @if($data['settings']->youtube_link)
            <a href="{{$data['settings']->youtube_link}}"><i class="fa fa-youtube"></i></a>
            @endif


        </div>

        @endif

    </div>

</footer>
<!-- /FOOTER -->


