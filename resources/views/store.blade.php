@extends('shared.base')

@section('title', 'Store')

@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- ASIDE -->
            <div id="aside" class="col-md-3">

                <!-- aside Widget -->
                <div class="aside">
                    <h3 class="aside-title">Brand</h3>
                    <div class="checkbox-filter">
                        @foreach($storeData["productBrands"] as $brand)
                        <div class="input-checkbox">
                            <input class="brand-checkbox" type="checkbox" data-slug="{{$brand->slug}}"
                                   id="brand-{{$brand->slug}}">
                            <label for="brand-{{$brand->slug}}">
                                <span></span>
                                {{$brand->name}}
                                <!--                                <small>(578)</small>-->
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /aside Widget -->

                <!-- aside Widget -->
                <div class="aside">
                    <h3 class="aside-title">Price</h3>
                    <div class="price-filter">
                        <div id="price-slider"></div>
                        <div class="input-number price-min">
                            <input id="price-min" type="number">
                            <span class="qty-up">+</span>
                            <span class="qty-down">-</span>
                        </div>
                        <span>-</span>
                        <div class="input-number price-max">
                            <input id="price-max" type="number">
                            <span class="qty-up">+</span>
                            <span class="qty-down">-</span>
                        </div>
                    </div>
                </div>
                <!-- /aside Widget -->

                <!-- aside Widget -->


                @foreach($storeData["featureCategories"] as $category)

                @if($category->is_filter && count($category->features) > 0)

                <div class="aside">
                    <h3 class="aside-title">{{$category->name}}</h3>
                    <div class="checkbox-filter">

                        @foreach($category->features as $feature)

                        <div class="input-checkbox">
                            <input class="feature-checkbox" type="checkbox" id="category-{{$feature->id}}"
                                   data-id="{{$feature->id}}">
                            <label for="category-{{$feature->id}}">
                                <span></span>
                                {{$feature->name}}
                                <!--                                <small>(740)</small>-->
                            </label>
                        </div>
                        @endforeach


                    </div>
                </div>
                @endif

                @endforeach
                <!-- /aside Widget -->
            </div>
            <!-- /ASIDE -->

            <!-- STORE -->
            <div id="store" class="col-md-9">
                <!-- store top filter -->
                <!--                <div class="store-filter clearfix">-->
                <!--                    <div class="store-sort">-->
                <!--                        <label>-->
                <!--                            Sort By:-->
                <!--                            <select class="input-select">-->
                <!--                                <option value="latest">Latest</option>-->
                <!--                                <option value="price">Price</option>-->
                <!--                                <option value="brand">Brand</option>-->
                <!--                            </select>-->
                <!--                        </label>-->
                <!---->
                <!--                        <label>-->
                <!--                            Show:-->
                <!--                            <select class="input-select">-->
                <!--                                <option value="12">12</option>-->
                <!--                                <option value="24">24</option>-->
                <!--                                <option value="36">36</option>-->
                <!--                            </select>-->
                <!--                        </label>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!-- /store top filter -->
                <input type="hidden" id="offset-value" value="{{$offset}}">
                <div id="product-area">

                    @if($products->count() > 0)
                    <!-- store products -->
                    <div class="row products">
                        <!-- product -->

                        @foreach($products as $product)
                        <div class="col-md-4 col-xs-6">
                            <div class="product">
                                <div class="product-img">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->slug }}">
                                    <!--                                    <div class="product-label">-->
                                    <!--                                        <span class="sale">-30%</span>-->
                                    <!--                                        <span class="new">NEW</span>-->
                                    <!--                                    </div>-->
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
                                    <!--                                <div class="product-rating">-->
                                    <!--                                    <i class="fa fa-star"></i>-->
                                    <!--                                    <i class="fa fa-star"></i>-->
                                    <!--                                    <i class="fa fa-star"></i>-->
                                    <!--                                    <i class="fa fa-star"></i>-->
                                    <!--                                    <i class="fa fa-star"></i>-->
                                    <!--                                </div>-->
                                    <!--                                <div class="product-btns">-->
                                    <!--                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span>-->
                                    <!--                                    </button>-->
                                    <!--                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span>-->
                                    <!--                                    </button>-->
                                    <!--                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span>-->
                                    <!--                                    </button>-->
                                    <!--                                </div>-->
                                </div>
                                <!--                            <div class="add-to-cart">-->
                                <!--                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>-->
                                <!--                            </div>-->
                            </div>
                        </div>

                        @endforeach
                        <!-- /product -->

                        <div class="clearfix visible-sm visible-xs"></div>
                    </div>
                    <!-- /store products -->

                    <!-- store bottom filter -->

                    <div class="store-filter">
                        <span class="store-qty">

                    </div>

                    @else
                    <h4 class="alert-danger">No Products Found</h4>
                    @endif
                </div>
                <!-- /store bottom filter -->
            </div>
            <!-- /STORE -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->
@endsection

@section('js')
@parent
<script src="{{ asset('js/site.js') }}"></script>
@endsection
