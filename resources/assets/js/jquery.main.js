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
    jQuery('a.smooth').smoothScroll({
        offset: ($('#header').height() * -1),
        scrollTarget: window.location.hash
    });
    jQuery('.count-to').countTo();
    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('.masonry-container').masonry({
        itemSelector: '.masonry-item'
    });

    var $bikingMap = jQuery('#biking-map');
    if($bikingMap.length == 1) {
        var height = Math.min(window.innerHeight, jQuery('.container').width() / 2);
        $bikingMap.width('100%').height(height+'px').vectorMap({
            map: 'europe_mill',
            zoomOnScroll: false,
            backgroundColor: '#ffffff',
            regionStyle: {
                initial: {
                    fill: '#9E9E9E',
                    "fill-opacity": 0.2,
                    stroke: 'none',
                    "stroke-width": 0,
                    "stroke-opacity": 1
                },
                hover: {
                    fill: '#424242',
                    "fill-opacity": 1,
                    cursor: 'normal'
                },
                selected: {
                    "fill-opacity": 1,
                    fill: '#FFB300'
                },
                selectedHover: {
                    "fill-opacity": 1,
                    fill: '#FF6F00'
                }
            },
            selectedRegions: $bikingMap.data('countries')
        });
    }
});