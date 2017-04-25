(function ($) {
    "use strict";

    /*---------------------
     TOP Menu Stick
     --------------------- */
    $(window).on("scroll",function() {
        if ($(this).scrollTop() > 300){
            $("#sticker").addClass("stick");
        }
        else{
            $("#sticker").removeClass("stick");
        }
    });

    /*---------------------
     countdown
     --------------------- */
    $("[data-countdown]").each(function () {
        var $this = $(this), finalDate = $(this).data("countdown");
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Minutes</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Second</p></span>'));
        });
    });

    /*----------------------------
     jQuery MeanMenu
     ------------------------------ */
    $('.mobile-menu nav').meanmenu({
        meanScreenWidth: "991",
        meanMenuContainer: ".mobile-menu",
    });

    /*----------------------------
     wow js active
     ------------------------------ */
    new WOW().init();

    /*----------------------------
     owl active
     ------------------------------ */
    $(".categorytab-carousel").owlCarousel({
        items: 5,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });
	
    $(".mostview-carousel, .latestblog-carousel").owlCarousel({
        items: 3,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
	
    $(".brandslider-carousel").owlCarousel({
        items: 6,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    });

    // home two
    $(".sale-products-carousel,.onsaleproduct-carousel,.testimonials-carousel,.sale-products-carousel4").owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
	
    $(".featureproduct-carousel").owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
	
    $(".bestseller-carousel").owlCarousel({
        items: 2,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    });
	
    $(".suggest-carousel").owlCarousel({
        items: 8,
        loop: true,
        nav: true,
        navSpeed: 2000,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 3
            },
            768: {
                items: 5
            },
            1000: {
                items: 8
            }
        }
    });

    /*----------------------------
     slideToggle
     ------------------------------ */
    $(".account-toggle").on("click", function () {
        $(".show-account-toggle").slideToggle();
    });

    $(".english-toggle").on("click", function () {
        $(".show-english-toggle").slideToggle();
    });

    $(".dollar-toggle").on("click", function () {
        $(".show-dollar-toggle").slideToggle();
    });

    $(".minicart-area .showcart").on("click", function () {
        $(".minicart-area .minicart-content").slideToggle();
    });

    /* $(".verticalmenu-container .megamenu-title").on("click", function () {
        $(".verticalmenu-container .vmegamenu").slideToggle();
    }); */

    $(".switcher-click").on("click", function () {
        $(".switcher-show").slideToggle();
    });

        /*-------------------------
      showlogin toggle function
    --------------------------*/
     $( '#showlogin' ).on('click', function() {
        $( '#checkout-login' ).slideToggle(900);
     }); 
    
    /*-------------------------
      showcoupon toggle function
    --------------------------*/
     $( '#showcoupon' ).on('click', function() {
        $( '#checkout_coupon' ).slideToggle(900);
     });
     
    /*-------------------------
      Create an account toggle function
    --------------------------*/
     $( '#cbox' ).on('click', function() {
        $( '#cbox_info' ).slideToggle(900);
     });
     
    /*-------------------------
      Create an account toggle function
    --------------------------*/
     $( '#ship-box' ).on('click', function() {
        $( '#ship-box-info' ).slideToggle(1000);
     });    
    

    /*----------------------------
     back-top
     ------------------------------ */
    // hide #back-top first
    $("#back-top").hide();
    // fade in #back-top
    $(window).on("scroll",function () {
        if ($(this).scrollTop() > 300) {
            $("#back-top").fadeIn();
            $("#back-top").addClass("show");
        } else {
            $("#back-top").fadeOut();
            $("#back-top").removeClass("show");
        }
    });
    // scroll body to 0px on click
    $("#back-top").on("click", function () {
        $("body,html").animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    /*----------------------------
     Range slider
     ------------------------------ */
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 200,
        values: [ 0, 200 ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - $" + $( "#slider-range" ).slider( "values", 1 ) );

    /*----------------------------
     collapse
     ------------------------------ */
    $(".payment-accordion").collapse({
        accordion:true,
        open: function() {
            this.slideDown(550);
        },
        close: function() {
            this.slideUp(550);
        }
    });
	
})(jQuery); 

$(document).ready(function(){
	
	// fancybox
	$('.fancybox').fancybox();

	$('body').on('click','.fancy-return',function(e){
		e.preventDefault();
		$.fancybox.close();
	});

	//getCart();
	//getFav();
	//getRecently();

	// Маска поля формы (телефон)
	$('.phone').mask('+79999999999');

	/***************************** Отправка формы "Обратный связь" по AJAX **********************************/
	$('#contact_form').on('beforeSubmit', function () {
		// Вызывается после удачной валидации всех полей и до того как форма отправляется на сервер.
		// Тут можно отправить форму через AJAX. Не забудьте вернуть false для того, чтобы форма не отправлялась как обычно.
		var form = $(this);
		$(".loading").show();
		$.post(
			'/main/default/send-contact-form', //form.attr('action'),
			form.serialize()
		)
		.complete(function(result){
			$(".loading").hide();
		})
		.done(function(result){
			if(result == 'success'){
				$(form).trigger('reset'); // Сбрасываем поля формы
				//Открываем попап благодарности
				$('#contact_form .form_success').show();
				$('#contact_form .form_success').html('<h2 class="popup_header_vsmall">Ваше сообщение успешно отправлено!</h2>');
			}
		});
		return false;
	});
	/***************************** Отправка формы "Обратный звонок" по AJAX **********************************/
	$('#recall_form').on('beforeSubmit', function () {
		// Вызывается после удачной валидации всех полей и до того как форма отправляется на сервер.
		// Тут можно отправить форму через AJAX. Не забудьте вернуть false для того, чтобы форма не отправлялась как обычно.
		var form = $(this);
		$(".loading").show();
		$.post(
			'/main/default/send-recall-form', //form.attr('action'),
			form.serialize()
		)
		.complete(function(result){
			$(".loading").hide();
		})
		.done(function(result){
			if(result == 'success'){
				$(form).trigger('reset'); // Сбрасываем поля формы
				//Открываем попап благодарности
				$('#recall_form .form_success').show();
				$('#recall_form .form_success').html('<h2 class="popup_header_vsmall">Ваше сообщение успешно отправлено!</h2>');
				$('#recall_form .group-submit').hide(); // Прячем кнопку формы после успешной отправки сообщения
			}
		});
		return false;
	});
});

function getCart()
{
	$.ajax({
		url: "/cart/getcart",
		dataType: "json",
		/* beforeSend: function() {
			$('#cart_block').html('<img src="/images/admin/loader.gif"/>');
		}, */
		success: function(data)
		{
			if(data.cart)
			{
				$('#cart_block').html(data.cart);
				if(data.qty > 0){
					
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}

function getFav()
{
	$.ajax({
		url: "/cart/getfav",
		dataType: "json",
		/* beforeSend: function() {
			$('#cart_block').html('<img src="/images/admin/loader.gif"/>');
		}, */
		success: function(data)
		{
			if(data.cart)
			{
				$('#fav_block').html(data.cart);
			}
		}
	})
}

function pageRenum(num){
	$.ajax({
		type: "POST",
		data: "num=" + num,
		url: "/ajax/renum",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				window.location = location.href;
			}
		}
	})
}

function getRecently()
{
	$.ajax({
		url: "/cart/get_recently",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				$('#recently_block').html(data.result);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}

function viewInformer(info)
{
	$('#popup-informer').html('');
	$('#popup-informer').html('<h2>'+info+'</h2>');
	$.fancybox.open('#popup-informer', {
		helpers: {
			overlay: {
				locked: false
			}
		}
	});
	window.setTimeout(function(){
		$('#popup-informer').html('');
		$.fancybox.close();
	}, 5000);
}

function addToCartAll(){

	var data = $('#fav_form').serialize();

	$.ajax({
		type: "POST",
		data: data,
		url: "/cart/set_all_data",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				getCart();
				/* viewInformer('Добавлено'); */
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}

function addToCart(product_code, prefix, is_options)
{
	if(is_options){
		$('#product_option_' + product_code + '_card_error').hide();
		if($('#product_option_' + product_code + '_' + prefix).val() == ''){
			$('#product_option_' + product_code + '_card_error').show();
			return;
		}
	}
	
	$.ajax({
		type: "POST",
		data: 'product_code=' + product_code + '&product_qty=' + $('#product_qty_' + product_code + '_' + prefix).val() + '&product_option=' + $('#product_option_' + product_code + '_' + prefix).val(),
		url: "/cart/setdata",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				getCart();
				$.fancybox({
					href: '/cart?is_popup=1',
					type: 'ajax',
					helpers: {
						overlay: {
							locked: false
						}
					}
				});
				/* viewInformer('В корзине ...');
				window.setTimeout(function(){
					$('#popup-informer').html('');
					$.fancybox.close();
				}, 2000); */
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	})
}

function addToFav(product_code)
{
	$.ajax({
		type: "POST",
		data: 'product_code=' + product_code,
		url: "/cart/setfav",
		dataType: "json",
		/* beforeSend: function() {
			$('#cart').html('<div class="cart-content"><img src="/images/admin/loader.gif"/></div>');
		}, */
		success: function(data)
		{
			if(data.result)
			{
				getFav();
				$.fancybox({
					href: '/favorites?is_popup=1',
					type: 'ajax',
					helpers: {
						overlay: {
							locked: false
						}
					}
				});
				/* viewInformer('Отложили ...');
				window.setTimeout(function(){
					$('#popup-informer').html('');
					$.fancybox.close();
				}, 2000); */
			}
		}
	})
}

function removeCart(code)
{
	$.ajax({
		type: "POST",
		data: "code=" + code,
		url: "/cart/remove",
		dataType: "json",
		beforeSend: function() {
			$('.load_indikator').show();
		},
		success: function(data)
		{
			$('.load_indikator').hide();
			if(data.result)
			{
				viewInformer('Товар удален из корзины');
				window.setTimeout(function(){
					window.location = '/cart';
				}, 1000);
			}
		}
	})
}

function removeCart2(code)
{
	$.ajax({
		type: "POST",
		data: "code=" + code,
		url: "/cart/remove",
		dataType: "json",
		/* beforeSend: function() {
			$('.load_indikator').show();
		}, */
		success: function(data)
		{
			//$('.load_indikator').hide();
			if(data.result)
			{
				getCart();
			}
		}
	})
}

function removeFav(code)
{
	$.ajax({
		type: "POST",
		data: "code=" + code,
		url: "/cart/removefav",
		dataType: "json",
		/* beforeSend: function() {
			$('.load_indikator').show();
		}, */
		success: function(data)
		{
			/* $('.load_indikator').hide(); */
			if(data.result)
			{
				getFav();
				viewInformer('Товар удален из списка');
				window.setTimeout(function(){
					window.location = '/favorites';
				}, 1000);
			}
		}
	})
}

function clearCart()
{
	$.ajax({
		url: "/cart/clear",
		dataType: "json",
		success: function(data)
		{
			if(data.result)
			{
				window.location = '/cart';
			}
		}
	})
}

function checkboxStatus(id){
	if(document.getElementById('status_' + id).checked){
		$('#statusfield_' + id).attr('value', 1);
	}else{
	   $('#statusfield_' + id).attr('value', 0);
	}
}

function OpenBlock(blockId)
{
    /* $('#'+blockId).dialog({
	  width: function(){$('#'+blockId).width()+20},
      modal: true
    }); */
	$('#' + blockId).show();
}

function CloseBlock(blockId)
{
	$('#' + blockId).hide();
}