
/***
 * GERAL
 ***/
$(function() {
    $('.animsition').animsition({
        inClass: 'fade-in-down-sm',
        outClass: 'fade-out-down-sm',
    }).one('animsition.inStart',function(){
        App.SetToggle();
        App.SetGaleria();
        App.SetBanner();
        App.SetCarouselMobile();
        App.SetHeaderFixed(80);
        App.SetValidate();
        App.SetMaskInput();
        App.SetInputError();
        App.SetFormSuccess();
        App.SetAnimatescroll(150);
        App.SetWow(200);
        App.SetCookies();

        $('html').addClass('loaded');

        // paralax
        $.stellar({
            horizontalScrolling: false,
            hideDistantElements: false,
        });

        // tabs
        $('.tabs').on('click', 'a', function(event) {
            event.preventDefault();
            let tab = this.dataset.tab;
            if (tab) {
                $('.tabs a').removeClass('_active');
                $(this).addClass('_active');
                $('.tab').hide();
                $(tab).show();
            }
        });

        // owl carousel
        $('[data-component=galeria-carousel]').each(function(index, el) {
            $(this).addClass('owl-carousel');
            $(this).owlCarousel({
                loop            : false,
                margin          : 20,
                autoplay        : false,
                nav             : true,
                navText         : ['<i class="icon-left"></i>', '<i class="icon-right"></i>'],
                dots            : false,
                responsive  : {0:{items : 1},500:{items : $(this).data("items")}},
            });
        });
    });
});