$(window).load(function () {   
    my_utils.banner_content_aligment ('.landing-banner', '.landing-banner-content');
    my_utils.banner_content_aligment ('.page-banner', '.page-banner-content');
    my_utils.equalize('.services-list', 'h3');
    my_utils.equalize('.services-list', 'p');
});

$(window).resize(function() { 
    my_utils.banner_content_aligment ('.landing-banner', '.landing-banner-content');
    my_utils.banner_content_aligment ('.page-banner', '.page-banner-content');
});  

$(document).ready(function() {
    $('#header').sticky({topSpacing: 0});
    my_utils.banner_content_aligment ('.landing-banner', '.landing-banner-content');
    my_utils.banner_content_aligment ('.page-banner', '.page-banner-content');
});

var my_utils = {
    equalize : function (selector, child) {
        $(selector).each(function() {

        var sameHeightChildren = $(selector).find(child);
        var maxHeight = 0;

        sameHeightChildren.each(function() {
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
        });

        sameHeightChildren.css({'min-height': maxHeight + 'px' });
        });
    },
    banner_content_aligment : function (banner_container, banner_content_container ) {
        $(banner_content_container).css( 'top', function() {
            return (($(banner_container).outerHeight() - $(banner_content_container).outerHeight())/2);
        });
    }      
}