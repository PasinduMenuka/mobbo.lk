<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div id="responsive-nav">
        <ul class="navbar1">
            <li><a href="/">Home</a></li>


            @foreach($data["categories"] as $category)
            <li>
                @if(count($category->categoryBrands) > 0)
                <a class="d-block d-sm-block d-lg-none"
                   href="{{route('Store', $category->slug)}}">{{$category->name}}</a>
                <div class="dropdown1 d-none d-sm-none d-lg-block">
                    <button class="dropbtn">
                        <a href="{{route('Store', $category->slug)}}">{{$category->name}}</a>
                    </button>
                    <div class="dropdown1-content">
                        <div class="header">
                        </div>
                        <div class="row">
                            @foreach($category->categoryBrands->brandChunks as $brandChunks)
                            <div class="column">

                                @foreach($brandChunks as $brand)
                                <a href="{{ route('Store', [$category->slug, 'brand' => $brand->brand->slug]) }}">
                                    <img src="{{$brand->brand->image}}" alt="{{$brand->brand->slug}}">
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @else
                <a href="{{route('Store', $category->slug)}}">{{$category->name}}</a>
                @endif
            </li>

            @endforeach

<!--            <li><a href="{{ route('AboutUs') }}">About Us</a></li>-->
            <li><a href="{{ route('ContactUs') }}">Contact Us</a></li>
        </ul>
        <!-- /container -->
</nav>
<!-- /NAVIGATION -->
