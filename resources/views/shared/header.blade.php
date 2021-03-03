<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            @if(isset($data['settings']))
            <ul class="header-links pull-left">
                @if($data['settings']->hotline)
                <li><a href="#"><i class="fa fa-phone"></i>{{$data['settings']->hotline}}</a></li>
                @endif
                @if($data['settings']->email)
                <li><a href="#"><i class="fa fa-envelope-o"></i> {{$data['settings']->email}}</a></li>
                @endif
                @if($data['settings']->address_line_1)
                <li><a href="#">
                        <i class="fa fa-map-marker"></i>
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
                    </a>
                </li>
                @endif
            </ul>
            @endif
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="/" class="logo">
                            @if(isset($data['settings']) && $data['settings']->shop_logo)
                            <img src="{{ $data['settings']->shop_logo }}" alt="{{ $data['settings']->shop_name }}">

                            @else
                            <img src="{{ asset('img/logo.png') }}" alt="">
                            @endif

                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <input type="hidden" id="search-text">
                        <form method="get" action="{{route('Store')}}">
                            <select class="input-select" id="search-drop" name="catSlug">
                                <option value="0">All Categories</option>
                                @foreach($data["categories"] as $category)
                                <option value="{{$category->slug}}">{{$category->name}}</option>
                                @endforeach

                            </select>
                            <input class="input" placeholder="Search here" name="searchKey">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <!--                        <div>-->
                        <!--                            <a href="#">-->
                        <!--                                <i class="fa fa-heart-o"></i>-->
                        <!--                                <span>Your Wishlist</span>-->
                        <!--                                <div class="qty">2</div>-->
                        <!--                            </a>-->
                        <!--                        </div>-->
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <!--                        <div class="dropdown">-->
                        <!--                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">-->
                        <!--                                <i class="fa fa-shopping-cart"></i>-->
                        <!--                                <span>Your Cart</span>-->
                        <!--                                <div class="qty">3</div>-->
                        <!--                            </a>-->
                        <!--                            <div class="cart-dropdown">-->
                        <!--                                <div class="cart-list">-->
                        <!--                                    <div class="product-widget">-->
                        <!--                                        <div class="product-img">-->
                        <!--                                            <img src="./img/product01.png" alt="">-->
                        <!--                                        </div>-->
                        <!--                                        <div class="product-body">-->
                        <!--                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>-->
                        <!--                                            <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>-->
                        <!--                                        </div>-->
                        <!--                                        <button class="delete"><i class="fa fa-close"></i></button>-->
                        <!--                                    </div>-->
                        <!---->
                        <!--                                    <div class="product-widget">-->
                        <!--                                        <div class="product-img">-->
                        <!--                                            <img src="./img/product02.png" alt="">-->
                        <!--                                        </div>-->
                        <!--                                        <div class="product-body">-->
                        <!--                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>-->
                        <!--                                            <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>-->
                        <!--                                        </div>-->
                        <!--                                        <button class="delete"><i class="fa fa-close"></i></button>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                                <div class="cart-summary">-->
                        <!--                                    <small>3 Item(s) selected</small>-->
                        <!--                                    <h5>SUBTOTAL: $2940.00</h5>-->
                        <!--                                </div>-->
                        <!--                                <div class="cart-btns">-->
                        <!--                                    <a href="#">View Cart</a>-->
                        <!--                                    <a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->
