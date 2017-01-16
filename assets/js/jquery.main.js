jQuery(window).on('load', function () {
    WebFont.load({
        google: {
            families: [
                'Lato:400,700',
                'Montserrat:700',
                'Raleway:400,700'
            ]
        }
    });
    jQuery('a.smooth').smoothScroll({offset: ($('#header').height() * -1)});
    jQuery('.count-to').countTo();
    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('.masonry-container').masonry({
        itemSelector: '.masonry-item'
    });
    // jQuery('.owl-carousel').owlCarousel({
    //     loop: true,
    //     margin: 10,
    //     nav: true,
    //     responsive: {
    //         0: {
    //             items: 1
    //         },
    //         768: {
    //             items: 2
    //         }
    //     }
    // });
});