/*  ---------------------------------------------------
    Template Name: codelean
    Description: codelean eCommerce HTML Template
    Author: CodeLean
    Author URI: https://CodeLean.vn/
    Version: 1.0
    Created: CodeLean
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
    $(".hero-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        Product Slider
    --------------------*/
   $(".product-slider").owlCarousel({
        loop: false,
        margin: 25,
        nav: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });

    /*------------------
       logo Carousel
    --------------------*/
    $(".logo-carousel").owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        mouseDrag: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 3,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });
    
    /*------------------
        CountDown
    --------------------*/
    // For demo preview
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if(mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end

    console.log(timerdate);
    

    // Use this for real timer date
    /* var timerdate = "2020/01/01"; */

	$("#countdown").countdown(timerdate, function(event) {
        $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" + "<div class='cd-item'><span>%H</span> <p>Hrs</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Mins</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Secs</p> </div>"));
    });

        
    /*----------------------------------------------------
     Language Flag js 
    ----------------------------------------------------*/
    $(document).ready(function(e) {
    //no use
    try {
        var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
            var val = data.value;
            if(val!="")
                window.location = val;
        }}}).data("dd");

        var pagename = document.location.pathname.toString();
        pagename = pagename.split("/");
        pages.setIndexByValue(pagename[pagename.length-1]);
        $("#ver").html(msBeautify.version.msDropdown);
    } catch(e) {
        // console.log(e);
    }
    $("#ver").html(msBeautify.version.msDropdown);

    //convert
    $(".language_drop").msDropdown({roundedBorder:false});
        $("#tech").data("dd");
    });
    /*-------------------
		Range Slider
	--------------------- */
	var rangeSlider = $(".price-range"),
    minamount = $("#minamount"),
    maxamount = $("#maxamount"),
    minPrice = rangeSlider.data('min'),
    maxPrice = rangeSlider.data('max'),
    minValue = rangeSlider.data('min-value') == '' ? rangeSlider.data('min-value') : minPrice,
    maxValue = rangeSlider.data('max-value') == '' ? rangeSlider.data('max-value') : maxPrice;
    rangeSlider.slider({
    range: true,
    min: minPrice,
    max: maxPrice,
    values: [minValue, maxValue],
    slide: function (event, ui) {
        minamount.val('$' + ui.values[0]);
        maxamount.val('$' + ui.values[1]);
    }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));


    /*-------------------
		Radio Btn
	--------------------- */
    $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").on('click', function () {
        $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").removeClass('active');
        $(this).addClass('active');
    });
    
    /*-------------------
		Nice Select
    --------------------- */
    $('.sorting, .p-show').niceSelect();

    /*------------------
		Single Product
	--------------------*/
	$('.product-thumbs-track .pt').on('click', function(){
		$('.product-thumbs-track .pt').removeClass('active');
		$(this).addClass('active');
		var imgurl = $(this).data('imgbigurl');
		var bigImg = $('.product-big-img').attr('src');
		if(imgurl != bigImg) {
			$('.product-big-img').attr({src: imgurl});
			$('.zoomImg').attr({src: imgurl});
		}
	});

    $('.product-pic-zoom').zoom();
    
    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
	proQty.prepend('<span class="dec qtybtn">-</span>');
	proQty.append('<span class="inc qtybtn">+</span>');
	proQty.on('click', '.qtybtn', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);

        //Update cart
        
        var rowId = $button.parent().find('input').data('rowid');
        if(rowId !== null && rowId !== undefined)
            updateCart(rowId, newVal);
	});
    
    /*-------------------
		Size change
	--------------------- */
    $('#showForm input').on('change', function() {
        var proSize = $('input[name=size]:checked', '#showForm').val();
        // console.log(proSize);
        for (var size in sizeArray) {
            if(size == proSize) {
                console.log(sizeArray[size]);
                $('.quantity-per-size').text(sizeArray[size] + ' pieces available');
                $('#qty-per-size').attr({
                    'max' : sizeArray[size]
                });
            }     
        }
      });

    /*-------------------
		Loc sp home webpage
	--------------------- */
    const product_men = $(".product-slider.men");
    const product_women = $(".product-slider.women");

    $('.filter-control').on('click', '.item', function() {
        const $item = $(this);
        const filter = $item.data('tag');
        const category = $item.data('category');

        $item.siblings().removeClass('active');
        $item.addClass('active');

        if (category === 'men') {
            product_men.owlcarousel2_filter(filter);
        }

        if (category === 'women') {
            product_women.owlcarousel2_filter(filter);
        }
    });

    /*-------------------
		Qty theo size
	--------------------- */
})(jQuery);

function addCart(productId) {
    $.ajax({
        type: "GET",
        url: "cart/add",
        data: {productId: productId},
        success: function (response) {
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['price-total']);
            $('.select-total h5').text('$' + response['price-total']);

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + response['cart'].rowId + "']");

            if(cartHover_existItem.length){
                cartHover_existItem.find('.product-selected p').text('$' + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty);
            }   
            else {
                var newItem = '<tr data-rowId="' + response['cart'].rowId + '">\n' +
                            '<td class="si-pic"><img src="front/img/products/' + response['cart'].options.images[0].path + '" alt=""></td>\n' +
                            '<td class="si-text">\n' +
                            '   <div class="product-selected">\n' +
                            '        <p>$' + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty + '</p>\n' +
                            '        <h6>' + response['cart'].name + '</h6>\n' +
                            '    </div>\n' +
                            '</td>\n' +
                            '<td class="si-close">\n' +
                            '    <i class="ti-close"></i>\n' +
                            '</td>\n' +
                            '</tr>\n';

                cartHover_tbody.append(newItem);
            }

            alert('Add successful!\nProduct: ' + response['cart'].name);
            console.log(response);
        },
        error: function (response) {
            alert('Add failed.');
            console.log(response);
        },
    });
}

function removeCart(rowId) {
    $.ajax({
        type: "GET",
        url: "cart/delete",
        data: {rowId: rowId},
        success: function (response) {
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['price-total']);
            $('.select-total h5').text('$' + response['price-total']);

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + rowId + "']");

            cartHover_existItem.remove();

            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            cart_existItem.remove();

            $('.price-total span').text('$' + response['price-total']);
            $('.cart-total span').text('$' + response['total']);

            alert('Delete successful!\nProduct: ' + response['cart'].name);
            console.log(response);
        },
        error: function (response) {
            alert('Delete failed.');
            console.log(response);
        },
    });
}

function destroyCart() {
    $.ajax({
        type: "GET",
        url: "cart/destroy",
        data: {},
        success: function (response) {
            $('.cart-count').text(0);
            $('.cart-price').text('$0.00');
            $('.select-total h5').text('$0.00');

            var cartHover_tbody = $('.select-items tbody');
            cartHover_tbody.children().remove();

            var cart_tbody = $('.cart-table tbody');
            cart_tbody.children().remove();

            $('.price-total span').text('$0.00');
            $('.cart-total span').text('$0.00');

            alert('Delete successful!\nProduct: ' + response['cart'].name);
            console.log(response);
        },
        error: function (response) {
            alert('Delete failed.');
            console.log(response);
        },
    });
}

function updateCart(rowId, qty) {
    $.ajax({
        type: "GET",
        url: "cart/update",
        data: {rowId: rowId, qty: qty},
        success: function (response) {
            $('.cart-count').text(response['count']);
            $('.cart-price').text('$' + response['price-total']);
            $('.select-total h5').text('$' + response['price-total']);

            var cartHover_tbody = $('.select-items tbody');
            var cartHover_existItem = cartHover_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty === 0) {
                cartHover_existItem.remove();
            } else {
                cartHover_existItem.find('.product-selected p').text('$' + response['cart'].price.toFixed(2) + ' x ' + response['cart'].qty);
            }
            

            var cart_tbody = $('.cart-table tbody');
            var cart_existItem = cart_tbody.find("tr" + "[data-rowId='" + rowId + "']");
            if (qty === 0) {
                cart_existItem.remove();
            } else {
                cart_existItem.find('.total-price').text('$' + (response['cart'].price * response['cart'].qty).toFixed(2));
            }

            $('.price-total span').text('$' + response['price-total']);
            $('.cart-total span').text('$' + response['total']);

            // alert('Update successful!\nProduct: ' + response['cart'].name);
            console.log(response);
        },
        error: function (response) {
            alert('Update failed.');
            console.log(response);
        },
    });
}

//Ajax blog comment
$(document).ready(function() {
    loadBlogComment();
    function loadBlogComment() {
        var blog_id = $('.blog_id').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            method: "GET",
            url: "blog/" + blog_id + "/load-comment",
            data: {blog_id: blog_id, _token: _token},
            success: function (response) {
                $('.posted-by').html(response);
            }
        });
    }

    $('.post-blog-comment').click(function() {
        var blog_id = $('.blog_id').val();
        var name = $('.name').val();
        var email = $('.email').val();
        var messages = $('.messages').val();
        var user_id = $('.user_id').val();
        var _token = $('input[name="_token"]').val();
    
        $.ajax({
            method: "POST",
            url: "blog/" + blog_id + "/post-comment",
            data: {
                blog_id: blog_id,
                name: name,
                email: email,
                messages: messages,
                checked: 0,
                user_id: user_id,
                _token: _token,
            },
            success: function (response) {
                $('.notify-comment').html('<p class="text text-success">Send comment successed!</p>');
                loadBlogComment();
                $('.name').val('');
                $('.email').val('');
                $('.messages').val('');
            },
            error: function (response) {
                $('.notify-comment').html('<p class="text text-danger">Send comment failed!</p>');
            }
        });
    });
});

//Ajax product comment
$(document).ready(function() {
    loadProductComment();
    function loadProductComment() {
        var product_id = $('.product_id').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            method: "GET",
            url: "shop/product/" + product_id + "/load-comment",
            data: {product_id: product_id, _token: _token},
            success: function (response) {
                $('.comment-option').html(response);
            }
        });
    }

    $('.post-product-comment').click(function() {
        var product_id = $('.product_id').val();
        var name = $('.name').val();
        var email = $('.email').val();
        var messages = $('.messages').val();
        var rating = $(".rating:checked").val();
        var user_id = $('.user_id').val();
        var _token = $('input[name="_token"]').val();
    
        $.ajax({
            method: "POST",
            url: "shop/product/" + product_id + "/post-comment",
            data: {
                product_id: product_id,
                name: name,
                email: email,
                messages: messages,
                rating: rating,
                checked: 0,
                user_id: user_id,
                _token: _token,
            },
            success: function (response) {
                $('.notify-comment').html('<p class="text text-success">Send comment successed!</p>');
                loadProductComment();
                $('.name').val('');
                $('.email').val('');
                $('.messages').val('');
            },
            error: function (response) {
                $('.notify-comment').html('<p class="text text-danger">Send comment failed!</p>');
            }
        });
    });
});

// = = = = = = = = = = = = = = = = changeImg = = = = = = = = = = = = = = = =
function changeImg(input) {
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function (e) {
            //Thay đổi đường dẫn ảnh
            $(input).siblings('.thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
//Khi click #thumbnail thì cũng gọi sự kiện click #image
$(document).ready(function () {
    $('.thumbnail').click(function () {
        $(this).siblings('.image').click();
    });
});

//Ajax coupon
$(document).ready(function () {
    $('.get-coupon').click(function () {
        var code = $('.code').val();
        var rowId = $('.rowId').val();
        console.log(rowId);
        var _token = $('input[name="_token"]').val();
        $.ajax({
            method: "GET",
            url: "cart/get-coupon",
            data: {
                code: code,
                rowId: rowId,
                _token: _token
            },
            success: function (response) {
                if(response['error']) {
                    $('.notify-comment').html('<p class="text text-danger">' + response['error'] + '</p>');
                    $('.code').val('');
                    setTimeout(function() {
                        $(".notify-comment").empty();
                    }, 1000);
                }
                else 
                    location.reload();
                // if(response['percentage-discount'])
                //     $('.discount span').text(response['percentage-discount'] + '%');
                // else 
                //     $('.discount span').text('$' + response['fixed-discount']);

                // $('.price-total span').text('$' + response['price-total']);
                // $('.cart-total span').text('$' + response['total']);
                // $('.code').val('');
                // $('.rowId').val(response['rowId']);
                // console.log(response['rowId']);
                // if($('.discount-coupon').find('span.up-cart').length == 0)
                //     $('.discount-coupon').append('<span onclick="removeCoupon(\'' + rowId + '\')" class="primary-btn up-cart">Remove discount</span>');
            },
            error: function (response) {
                $('.notify-comment').html('<p class="text text-danger">Code not found!</p>');
                $('.code').val('');
                setTimeout(function() {
                    $(".notify-comment").empty();
                }, 1000);
            }
        });
    });
});

function removeCoupon(rowId) {
    $.ajax({
        type: "GET",
        url: "cart/remove-coupon",
        data: {rowId: rowId},
        success: function (response) {
            location.reload();
            // console.log(response['rowId']);
            // $('.discount span').text('');
            // $('.cart-total span').text('$' + response['total']);
            // $('.up-cart').remove();
            // $('.code').val('');
        },
        error: function (data) {
           
        },
    });
}
