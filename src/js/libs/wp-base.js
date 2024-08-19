/***
 * FUNCTIONS
 ***/
// Check mobile
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

var App = {
    SetToggle: function() {
        $('[data-component="toggle"]').each(function(index, el) {
            $(el).click(function(event) {
                event.preventDefault();
                type   = $(this).data('type');
                target = $(this).data('target');
                if (type == 'menu') {
                    $('body').toggleClass('_toggled');
                } else {
                    $(target).toggleClass('_hide');
                }
            });
        });
    },
    SetGaleria: function() {
        // Galeria
        $('[data-component=galeria]').each(function(index, el) {
            $(el).magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                  enabled:true
                }
            });
        });

    },
    SetBanner: function() {
        // owl carousel
        $('[data-component=banner]').each(function(index, el) {
            $(this).addClass('owl-carousel');
            $(this).owlCarousel({
                loop            : true,
                items           : 1,
                autoplay        : true,
                autoplayTimeout : $(this).data("autoplay-timeout"),
                nav             : $(this).data("nav"),
                animateOut      : 'fadeOut',
                navText         : ['<i class="icon-left"></i>', '<i class="icon-right"></i>'],
                dots            : true,
            });
        });
    },
    SetCarouselMobile: function() {
        $('[data-component=carousel-mobile]').each(function(index, el) {
            $(document).ready(function() {
                if ( $(window).width() <= 768 ) {
                    startCarousel();
                } else {
                    stopCarousel();
                }
            });

            $(window).resize(function() {
                if ( $(window).width() <= 768 ) {
                    startCarousel();
                } else {
                    stopCarousel();
                }
            });

            function startCarousel(){
                $('[data-component=carousel-mobile]').addClass('owl-carousel');

                $('[data-component=carousel-mobile]').owlCarousel({
                    loop        : true,
                    autoplay    : true,
                    nav         : false,
                    dots        : false,
                    responsive  : {0:{items : 1},500:{items : $('[data-component=carousel-mobile]').data("items")}},
                });
            }
            function stopCarousel() {
                $('[data-component=carousel-mobile]').trigger('destroy.owl.carousel');
                $('[data-component=carousel-mobile]').removeClass('owl-carousel');
            }
        });
    },
    SetHeaderFixed: function($top) {
        $('[data-component=fixed]').each(function(index, el) {
            $(window).scroll(function () {
                if ($(window).scrollTop() > $top) {
                    $('[data-component=fixed]').addClass('_fixed');
                } else {
                    $('[data-component=fixed]').removeClass('_fixed');
                }
            }); 
        }); 
    },
    SetValidate: function() {
        $('form').each(function () {
            if ($(this).attr('id') != 'frmLogin' && $(this).attr('id') != 'alugar') {
                $(this).find('.Button').after("<div class='Message' id='mensagem' style='display:none'></div>");
                $(this).find('.Button').after('<svg style="display:none;" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="loading" style="background: none;"><g transform="rotate(28.345 50 50)"><path d="M50 15A35 35 0 1 0 74.787 25.213" fill="none" ng-attr-stroke="{{config.color}}" ng-attr-stroke-width="{{config.width}}" stroke="#28292f" stroke-width="12"/><path ng-attr-d="{{config.darrow}}" ng-attr-fill="{{config.color}}" d="M49 3L49 27L61 15L49 3" fill="#28292f"/><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"/></g></svg>');

                $(this).validate({
                    errorClass: "_error",
                    errorElement: "span",
                    debug: true,
                    onsubmit: true,
                    submitHandler: function(form) {
                        $(form).find('.loading').show(); 
                        $(form).find(".Button").attr("disabled", true);

                        var $form    = $(form);
                        var formId   = $form.attr('id');
                        var formData = new FormData(form);

                        if (formId == 'form_whatsapp') {
                            $(form).find(".Button").attr("disabled", false);
                            $(form).find('.Message').removeClass('_success');
                            $(form).find('.loading').hide();
                            window.open("https://api.whatsapp.com/send?phone=5516997735686");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: $(form).attr('action'),
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (e) {
                                    $(form).find('.Message').addClass('_success');
                                    $(form).find('.Message').removeClass('_error');
                                    $(form).find('.loading').hide();
                                    $(form).find('.Message').html('<h5 class="_mb10 _w100">Obrigado!</h5><p>Seus dados foram enviados com sucesso.</p>')
                                        .hide()
                                        .fadeIn(1500);
                                    $(form).trigger('reset');
                                },
                                error: function (e) {
                                    $(form).find(".Button").attr("disabled", false);
                                    $(form).find('.Message').addClass('_error');
                                    $(form).find('.Message').removeClass('_success');
                                    $(form).find('.loading').hide();
                                    $(form).find('.Message').html("<h5>Ocorreu um erro ao enviar sua mensagem.</h5>")
                                        .hide()
                                        .fadeIn(1500);
                                },
                            });
                        }

                       return false; 
                    }
                });
            }
        });
    },
    SetAnimatescroll: function($padding) {

        // Scroll
        $('.scroll').on('click', function(event) {
            var data   = $(this).data('target');
            var href   = $(this).attr('href');
            var target = (data !== undefined) ? data : href;

            $(target).animatescroll({
                scrollSpeed: 800,
                easing: 'easeOutExpo',
                padding: $padding,
            });
        });

        $('body').scrollspy({
            target: '.Header nav',
            offset: $padding
        });
    },
    SetMaskInput: function() {
        // remove autocomplete
        $('form').attr('autocomplete', 'off').attr('autosuggest', 'off');

        // Input masks
        $("input.cpf").mask("999.999.999-99");
        $("input.cnpj").mask("99.999.999/9999-99");
        $("input.data").mask("99/99/9999");
        $("input.cep").mask("99999-999");
        $("input.hora").mask("99:99");
        
        var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
          onKeyPress: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        $(".telefone").mask(SPMaskBehavior, spOptions);
    },
    SetInputError: function() {
        // Add error input
        $('._error li').each(function(item) {
            var item = $(this).attr('class');
            var element = document.getElementsByName(item)[0];
            
            element.classList.add("_error");
        });

        $('.modal').click('.modal-close', function(event) {
            $('.modal').hide();
            $('html').removeClass('_no-scroll');
        });
    },
    SetFormSuccess: function() {
        // Add class _success Form
        var $get_success = window.location.search.substring(1);

        if ($get_success == 'success=1') {
            $('.Form').addClass('_success');
            $('html').addClass('_no-scroll');

            // Landing page
            $('.Landing_page .download').toggleClass('_hide');
        }
    },
    SetWow: function($offset) {
        new WOW({
            offset: $offset
        }).init();
    },
    SetCookies: function() {
        if (localStorage.hasOwnProperty('verify_cookies')) {
            $('.Cookies').addClass('_hide');
        }

        $('.Cookies .Button').click(function(event) {
            event.preventDefault();
            localStorage.setItem('verify_cookies', true);
            $('.Cookies').addClass('_hide');
        });
    },
};

$.gmap3(false);