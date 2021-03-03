var position = $(window).scrollTop();
var bottom = $(document).height() - $(window).height();

windowScroll();
storeFilters();


let brandArray = [];
let featureArray = [];
let brand = '';
let feature = '';
let minPrice = 1.00;
var tempMin = null;
var tempMax = null;
let maxPrice = 1000000.00;

$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results ? results[1] || 0 : null;
}

function windowScroll() {
    $(window).scroll(function () {

        var position = $(window).scrollTop();
        var bottom = $(document).height() - $(window).height();

        if (position === bottom) {
            console.log("cccc")

            sendFilterReq();
        }

    });
}

function storeFilters() {

    $(document).ready(function () {

        let selectedBrand = decodeURIComponent($.urlParam('brand'))
        if (selectedBrand) {
            $('.brand-checkbox').each(function () {
                if ($(this).attr('data-slug') === selectedBrand) {
                    $(this).prop("checked", true);
                    brandArray.push($(this).data("slug"))
                    brand = brandArray.toString();
                }
            })
        }

        $('.brand-checkbox').click(function () {
            if ($(this).prop("checked") === true) {
                brandArray.push($(this).data("slug"))
            } else if ($(this).prop("checked") === false) {
                brandArray.splice(brandArray.indexOf($(this).data("slug")), 1);
            }
            brand = brandArray.toString();

            sendFilterReq(true);
        });

        $('.feature-checkbox').click(function () {
            if ($(this).prop("checked") === true) {
                featureArray.push($(this).data("id"))
            } else if ($(this).prop("checked") === false) {
                featureArray.splice(featureArray.indexOf($(this).data("id")), 1);
            }
            feature = featureArray.toString();

            sendFilterReq(true);
        });

        let priceSlider = document.getElementById('price-slider');
        priceSlider.noUiSlider.on('update', function (values, handle) {
            let value = values[handle];
            handle ? tempMax = value : tempMin = value
            if (tempMin && tempMax) {
                if (!($("#price-min").val() === '1.00' && $("#price-max").val() === '1000000.00')) {
                    // window.location.replace("store?brand=" + brand + "&price=" + tempMin + "," + tempMax)
                    sendFilterReq(true);
                }
            }
        });
    });


}

function sendFilterReq(isFilter = false) {

    let offset = $('#offset-value').val();
    if (isFilter) {
        offset = 0;
    }

    $.ajax({
        type: 'GET',
        url: window.location.pathname + '?offset=' + offset + '&lazy=1&brand='
            + brand + '&price=' + tempMin + ',' + tempMax + '&features=' + feature,
        success: function (response) {
            if (isFilter) {
                $('#product-area').empty();
            }

            $('#offset-value').val(response.offset);

            let element = '';

            if (Object.keys(response.products).length > 0) {
                if (isFilter) {
                    element += '<div class="row products">';
                }


                for (let p of Object.keys(response.products)) {
                    let product = response.products[p];
                    element += '<div class="col-md-4 col-xs-6">' +
                        '<div class="product">' +
                        '<div class="product-img">' +
                        '<img src="' + product.image_url + '" alt="' + product.slug + '">' +
                        '<div class="product-label">' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-body">' +
                        '<p class="product-category">' + product.category.name + '</p>' +
                        '<h3 class="product-name"><a href="/product/' + product.slug + '">' + product.name + '</a>' +
                        '</h3>';

                    if (product.featureNames) {
                        element += '<p class="product-category">' + product.featureNames + '</p>';
                    } else {
                        element += '<p class="product-category" style="visibility: hidden">Nothing</p>';
                    }
                    element += '<h4 class="product-price">';

                    if (product.off_price) {
                        element += 'LKR ' + product.off_price;
                        element += '&nbsp;<del class="product-old-price">LKR ' + product.price + '</del>';
                    } else {
                        element += 'LKR ' + product.price;
                    }


                    element += '</h4>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                }
                if (isFilter) {
                    element += '</div>';
                }
            }

            if (isFilter) {
                $('#product-area').append(element);
            } else {
                $('.products').append(element);
            }


        }

    });
}



