jQuery(window).on('load', function() {
    jQuery('a.smooth').smoothScroll();
    jQuery('.count-to').countTo();
    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('.masonry-container').masonry({
        itemSelector: '.masonry-item'
    });
});