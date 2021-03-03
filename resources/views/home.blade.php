@extends('shared.base')

@section('title', 'Home')

@section('content')

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">


        <div class="w3-content1" style="max-width:1700px">
            <div class="slideshow-container">

                @foreach($bannerImages as $image)
                <img class="mySlides" src="{{$image->image_url}}" style="width:100%">
                @endforeach
            </div>
        </div>

        <br>
        <!-- row -->
        <div class="row">
            <!-- shop -->
            @foreach($data['categories'] as $category)

            <div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="{{$category->image_url}}" alt="{{$category->slug}}">
                    </div>
                    <div class="shop-body">
                        <br>
                        <br>
                        <br>
                        <a href="{{route('Store', $category->slug)}}" class="cta-btn"><b>Shop now</b><i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            @endforeach
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->

        @foreach($brandCategories as $brandCategory)

        @if(count($brandCategory->products) > 0)

        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <button class="button-home"><span>{{$brandCategory->category->name}} - {{$brandCategory->brand->name}} </span>
                    </button>

                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab1" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-{{$brandCategory->id}}">
                                <!-- product -->

                                @foreach($brandCategory->products as $product)
                                <div class="product">
                                    <div class="product-img">
                                        <img src="{{$product->image_url}}" alt="{{$product->slug}}">
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">{{$brandCategory->category->name}}</p>
                                        <h3 class="product-name"><a href="{{route('Product', $product->slug)}}">{{$product->name}}</a>
                                        </h3>
                                        @if($product->featureNames)
                                        <p class="product-category">{{$product->featureNames}}</p>
                                        @else
                                        <p class="product-category" style="visibility: hidden">Nothing</p>
                                        @endif
                                        <h4 class="product-price">
                                            @if($product->off_price)
                                            LKR {{$product->off_price}}
                                            <del class="product-old-price">LKR {{$product->price}}</del>
                                            @else
                                            LKR {{$product->price}}
                                            @endif
                                        </h4>

                                    </div>
                                </div>

                                @endforeach


                                <!-- /product -->

                            </div>
                            <div id="slick-nav-{{$brandCategory->id}}" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
        </div>

        @endif
        @endforeach


    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- HOT DEAL SECTION -->
@foreach($hotDeals as $deal)
<div id="hot-deal{{$deal->id}}" class="section" style="background-image: url('{{$deal->image_url}}')">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="hot-deal">
                    <h2 class="text-uppercase">{{$deal->title}}</h2>
                    <p>{{$deal->description}}</p>
                    <a class="primary-btn cta-btn" href="{{route('Store', $deal->category->slug)}}">{{$deal->button_text}}</a>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
@endforeach
<!-- /HOT DEAL SECTION -->

<!-- SECTION -->

@if(count($topSellings) >0)
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Top selling</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">

                            @foreach($topSellings as $category)
                            @if($category->key === 0)
                            <li class="active"><a data-toggle="tab"
                                                  href="#tab{{$category->key}}">{{$category->name}}</a></li>

                            @else
                            <li><a data-toggle="tab" href="#tab{{$category->key}}">{{$category->name}}</a></li>


                            @endif


                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        @foreach($topSellings as $category)

                        @if($category->key === 0)
                        <div id="tab{{$category->key}}" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <!-- product -->
                                @foreach($category->items as $product)
                                <div class="product">
                                    <div class="product-img">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->slug }}">
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">{{$category->name}}</p>
                                        <h3 class="product-name"><a href="{{route('Product', $product->slug)}}">{{$product->name}}</a>
                                        </h3>
                                        @if($product->featureNames)
                                        <p class="product-category">{{$product->featureNames}}</p>
                                        @else
                                        <p class="product-category" style="visibility: hidden">Nothing</p>
                                        @endif
                                        <h4 class="product-price">
                                            @if($product->off_price)
                                            LKR {{$product->off_price}}
                                            <del class="product-old-price">LKR {{$product->price}}</del>
                                            @else
                                            LKR {{$product->price}}
                                            @endif


                                        </h4>
                                    </div>
                                </div>
                                @endforeach
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        @else
                        <div id="tab{{$category->key}}" class="tab-pane fade in">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <!-- product -->
                                @foreach($category->items as $product)
                                <div class="product">
                                    <div class="product-img">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->slug }}">
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category">{{$product->category->name}}</p>
                                        <h3 class="product-name"><a href="{{route('Product', $product->slug)}}">{{$product->name}}</a>
                                        </h3>
                                        @if($product->featureNames)
                                        <p class="product-category">{{$product->featureNames}}</p>
                                        @else
                                        <p class="product-category" style="visibility: hidden">Nothing</p>
                                        @endif
                                        <h4 class="product-price">
                                            @if($product->off_price)
                                            LKR {{$product->off_price}}
                                            <del class="product-old-price">LKR {{$product->price}}</del>
                                            @else
                                            LKR {{$product->price}}
                                            @endif


                                        </h4>
                                    </div>
                                </div>
                                @endforeach
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        @endif

                        @endforeach

                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
@endif
<!-- /SECTION -->
@endsection

@section('js')
@parent
<script>
    var slideIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        // console.log(x)
        slideIndex++;
        if (slideIndex > x.length) {
            slideIndex = 1
        }
        if (x.length > 0) {
            x[slideIndex - 1].style.display = "block";
        }

        setTimeout(carousel, 2000);
    }
</script>
@endsection

@section('js')
@parent

@endsection
