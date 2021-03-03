$(document).ready(function () {
    let featureArray = [];
    let productId = $('#product-id').val();

    $('.product-features').each(function () {
            let featureCategory = $(this).data('feature-cat');
            featureArray[featureCategory] = $(this).children("option:selected").val();
        }
    )
    $(document).on('change', '.product-features', function () {
        let featureCategory = $(this).data('feature-cat');
        featureArray[featureCategory] = $(this).children("option:selected").val();

        sendCall(featureArray, productId);
    });


    let productName = $('#product-name').val();
    let brandName = $('#product-brand').val();

    $('.api').fonoApi({
        token: "07098efc8fc0637d5221f2c41b665331f1779a55ac7b6cf6",
        device: productName,
        brand: brandName,
        limit: 50,
        template: function () {

            // argument contains the data object // *returns html content
            return $.map(arguments, function (obj, i) {

                if (obj.DeviceName.toLowerCase() === productName.toLowerCase()) {
                    content = '<h3>' + obj.DeviceName + '</h3>';
                    content += '<table class="table table-striped" style="width:100%">';
                    content += '<tr><th>info</th><th>Description</th></tr>';

                    for (var key in obj) {
                        content += "<tr><td>" + key + "</td><td>" + obj[key] + "</td><tr>";
                    }

                    content += "</table>";
                    return $('<div class="table-responsive"></div>').append(content);
                }

            });

        }
    });

})


function sendCall(featureArray, productId) {

    featureArray = featureArray.filter(ar => ar != null || ar !== undefined);

    $.ajax({
        type: 'POST',
        data: {
            "_token": $('#csrf-token')[0].content, //pass the CSRF_TOKEN()
            'features': JSON.stringify(featureArray),
            'productId': productId
        },
        url: window.location.pathname + '',
        success: function (response) {

            if (response && response.unique_id) {

                $('.product-id').text('Item No ' + response.unique_id);

                $('.product-info').empty();

                let info = '<div class="product-info">' +
                    '<h3 class="product-price">';


                if (response.off_price) {
                    info += 'LKR. ' + response.off_price;
                    info += '<del class="product-old-price">LKR. ' + response.price + '</del>'
                } else {
                    info += 'LKR. ' + response.price + '';
                }
                info += '</h3>';


                if (response.in_stock) {
                    info += '<span class="product-available">In Stock</span>';
                } else {
                    info += '<span class="product-not-available">Out of Stock</span>';
                }

                info += '</div>';

                $('.product-info').append(info);


                $('#product-main-img').empty();
                $('#product-imgs').empty();

                let mainImg = '';

                response.product_images.forEach(image => {

                    mainImg += '<div class="product-preview">' +
                        '<img src="' + image.image_url + '" alt="' + response.slug + '">' +
                        '</div>'

                })

                $('#product-main-img').append(mainImg)
                $('#product-imgs').append(mainImg)


                if ($('#product-main-img').hasClass('slick-initialized')) {
                    $('#product-main-img').removeClass("slick-initialized slick-slider");
                }
                if ($('#product-imgs').hasClass('slick-initialized')) {
                    $('#product-imgs').removeClass('slick-initialized slick-slider');
                }

                // ProductSeeder Main img Slick
                $('#product-main-img').slick({
                    infinite: true,
                    speed: 300,
                    dots: false,
                    arrows: true,
                    fade: true,
                    asNavFor: '#product-imgs',
                });


                // ProductSeeder imgs Slick
                $('#product-imgs').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    centerMode: true,
                    focusOnSelect: true,
                    centerPadding: 0,
                    vertical: true,
                    asNavFor: '#product-main-img',
                    adaptiveHeight: true,
                    responsive: [{
                        breakpoint: 991,
                        settings: {
                            vertical: false,
                            arrows: false,
                            dots: true,
                        }
                    },
                    ]
                });


                // ProductSeeder img zoom
                var zoomMainProduct = document.getElementById('product-main-img');
                if (zoomMainProduct) {
                    $('#product-main-img .product-preview').zoom();
                }

            } else {
                alertify
                    .alert('Product not available', "No products available for your selection. Try others.", function(){
                        // alertify.message('OK');
                    });
            }
        }
    });
}
