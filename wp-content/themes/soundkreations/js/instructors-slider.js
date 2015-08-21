var sliderInterval = 0;
var firstElementWidth = 0;
var intSlidesVisible = 0;

function navigateRight() {
    clearInterval(sliderInterval);
    var marginLeft = parseInt(jQuery(".instructors-list").css("margin-left"));
    var intSlideCount = -1 * Math.round(marginLeft / firstElementWidth);

    if (intSlideCount + intSlidesVisible == (jQuery(".instructors-container .instructors-list .instructor").length)) {
        var newMarginLeft = marginLeft;
        // check if the last slide is only partially visible
        if (firstElementWidth * intSlidesVisible > jQuery(window).width()) {
            newMarginLeft = -1 * (firstElementWidth * intSlidesVisible - jQuery(window).width()) + marginLeft;
            jQuery(".instructors-navigation .instructors-next").addClass("disabled");
        }

        jQuery(".instructors-list").css("margin-left", newMarginLeft + "px");
    } else if (intSlideCount + intSlidesVisible == (jQuery(".instructors-container .instructors-list .instructor").length - 1)) {
        var newMarginLeft = marginLeft - firstElementWidth;
        if (firstElementWidth * intSlidesVisible < jQuery(window).width()) {
            jQuery(".instructors-navigation .instructors-next").addClass("disabled");
        }
        jQuery(".instructors-list").css("margin-left", newMarginLeft + "px");
    } else {
        var newMarginLeft = marginLeft - firstElementWidth;
        jQuery(".instructors-list").css("margin-left", newMarginLeft + "px");
    }
    jQuery(".instructors-navigation .instructors-prev").removeClass("disabled");
}

function navigateLeft() {
    clearInterval(sliderInterval);
    var marginLeft = parseInt(jQuery(".instructors-list").css("margin-left"));
    var intSlideCount = -1 * Math.round(marginLeft / firstElementWidth);
    if (marginLeft < 0) {
        var newMarginLeft = marginLeft + firstElementWidth;
        jQuery(".instructors-list").css("margin-left", newMarginLeft + "px");
        if (newMarginLeft == 0) {
            jQuery(".instructors-navigation .instructors-prev").addClass("disabled");
        }
    }
    jQuery(".instructors-navigation .instructors-next").removeClass("disabled");
}

function onResize() {
    jQuery(".instructors-list").css("margin-left", "0");
    jQuery(".instructors-navigation .instructors-prev").addClass("disabled");
    firstElementWidth = jQuery(".instructors-list .instructor:first-child").width();
    intSlidesVisible = Math.ceil(jQuery(window).width() / firstElementWidth);
}

jQuery(document).ready(function ($) {
    $(window).on("resize", onResize);
    $(".instructors-navigation .instructors-prev").addClass("disabled");
    firstElementWidth = $(".instructors-list .instructor:first-child").width();
    intSlidesVisible = Math.ceil($(window).width() / firstElementWidth);
    setTimeout(onResize, 500);
    $(".instructors-navigation .instructors-prev").on("click", navigateLeft);
    $(".instructors-navigation .instructors-next").on("click", navigateRight);
});