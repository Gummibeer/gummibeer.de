jQuery(window).on('load', function () {

    var $progress = jQuery('#deck-progress');
    jQuery(document).on('deck.init', function() {
        console.log(jQuery.deck('getSlides'));
        for(var i = 0; i < jQuery.deck('getSlides').length; i++) {
            $progress.append(jQuery('<div/>').addClass('bar'));
        }
    }).on('deck.change', function (event, from, to) {
        console.log(from, to);
        var $bars = $progress.find('.bar');
        console.log($bars);
        $bars.removeClass('done').removeClass('current');
        var $current = $bars.eq(to);
        console.log($current);
        $current.addClass('current');
        $current.prevAll().addClass('done');
    });

    jQuery.deck('.slide');
});
