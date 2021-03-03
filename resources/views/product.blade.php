@extends('shared.base')

@section('title', $product->name)

@section('content')

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    @foreach($product->productImages as $image)

                    <div class="product-preview">
                        <img src="{{ $image->image_url }}" alt="{{ $product->slug }}">
                    </div>

                    @endforeach
                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <div id="product-imgs">
                    @foreach($product->productImages as $image)

                    <div class="product-preview">
                        <img src="{{ $image->image_url }}" alt="{{ $product->slug }}">
                    </div>

                    @endforeach
                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->
            <div class="col-md-5">
                <div class="product-details">

                    @if(isset($product->product_id))
                    <input hidden id="product-id" value="{{$product->product_id}}">

                    @endif
                    <input hidden id="product-name" value="{{$product->name}}">
                    <input hidden id="product-brand" value="{{$product->brand->name}}">
                    <h2 class="product-name">{{$product->name}}</h2>
                    <div class="product-links product-id">Item No : {{$product->unique_id}}</div>
                    <div class="product-info">
                        <h3 class="product-price">

                            @if($product->off_price)
                            LKR. {{$product->off_price}}
                            <del class="product-old-price">LKR. {{$product->price}}</del>
                            @else
                            LKR. {{$product->price}}
                            @endif


                        </h3>
                        @if($product->in_stock)
                        <span class="product-available">In Stock</span>
                        @else
                        <span class="product-not-available">Out of Stock</span>
                        @endif
                    </div>
                    <p>{{$product->short_desc}}</p>

                    <div class="product-options">
                        @if(isset($featureCategories))
                        @foreach($featureCategories as $featureCategory)
                        <label style="padding-bottom: 4px">
                            {{$featureCategory->name}}
                            <select class="input-select product-features" data-feature-cat="{{$featureCategory->id}}"
                                    id="{{$featureCategory->id}}">
                                @foreach($featureCategory->features as $feature)
                                @if($feature->selected)
                                <option value="{{$feature->id}}" selected>{{$feature->name}}</option>
                                @else
                                <option value="{{$feature->id}}">{{$feature->name}}</option>
                                @endif

                                @endforeach
                            </select>
                        </label>
                        @endforeach
                        @endif
                    </div>
                    <ul class="product-links product-category">
                        <li>Category:</li>
                        <li><a href="{{ route('Store', $product->category->slug) }}">{{$product->category->name}}</a>
                        </li>
                    </ul>

                    <ul class="product-links product-brand">
                        <li>Brand:</li>
                        <li>
                            <a href="{{ route('Store', ['brand'=> $product->brand->slug]) }}">{{$product->brand->name}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Product details -->

            <!-- Product tab -->
            <div class="col-md-12">
                <div id="product-tab">
                    <!-- product tab nav -->
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                        <li><a data-toggle="tab" href="#tab2">Details</a></li>
                        <!--                        <li><a data-toggle="tab" href="#tab3">Reviews (3)</a></li>-->
                    </ul>
                    <!-- /product tab nav -->

                    <!-- product tab content -->
                    <div class="tab-content">
                        <!-- tab1  -->
                        <div id="tab1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>

                                        {{$product->long_desc}}

                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /tab1  -->

                        <!-- tab2  -->
                        <div id="tab2" class="tab-pane fade in">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="disclaimer" style="background-color: #d5d5d5; padding: 16px; margin-bottom: 16px">
                                        Disclaimer - We can not guarantee that the information on this page is 100% correct since This is pulled from a 3rd party API. If you think that any information for the current phone is wrong or missing, please contact us before your purchases.
                                    </div>

                                    <div class="api">
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /product tab content  -->
                </div>
            </div>
            <!-- /product tab -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- Section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        @if(count($relatedProducts) > 0)
        <div class="row">

            <div class="col-md-12">
                <div class="section-title text-center">
                    <h3 class="title">Related Products</h3>
                </div>
            </div>

            <!-- product -->
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3 col-xs-6">
                <div class="product">
                    <div class="product-img">
                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->slug }}">
                        <div class="product-label">
                            <!--                            <span class="sale">-30%</span>-->
                        </div>
                    </div>
                    <div class="product-body">
                        <p class="product-category">{{$relatedProduct->category->name}}</p>
                        <h3 class="product-name"><a href="{{ route('Product', $relatedProduct->slug) }}">{{$relatedProduct->name}}</a>
                        </h3>
                        @if($relatedProduct->featureNames)
                        <p class="product-category">{{$relatedProduct->featureNames}}</p>
                        @else
                        <p class="product-category" style="visibility: hidden">Nothing</p>
                        @endif
                        <h4 class="product-price">
                            @if($product->off_price)
                            LKR. {{$product->off_price}}
                            <del class="product-old-price">LKR. {{$product->price}}</del>
                            @else
                            LKR. {{$product->price}}
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- /product -->

        </div>
        @endif
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /Section -->

@endsection
@section('js')
@parent
<script src="{{ asset('js/fonoapi.jquery.min.js') }}"></script>
<script src="{{ asset('js/product.js') }}"></script>
@endsection
