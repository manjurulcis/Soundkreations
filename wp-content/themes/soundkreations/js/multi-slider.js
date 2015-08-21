var interval = 0;

function multipager_slide() {
    if (jQuery(".multi-pager .icon.current").next().length > 0) {
        jQuery(".multi-pager .icon.current").next().addClass("current-pending");
        jQuery(".multi-pager .icon.current").removeClass("current");
        jQuery(".multi-pager .icon.current-pending").removeClass("current-pending").addClass("current");
    } else {
        jQuery(".multi-pager .icon.current").removeClass("current");
        jQuery(".multi-pager .icon:first-child").addClass("current");
    }
    jQuery(".multi-pager .page").removeClass("current");
    jQuery(".multi-pager ." + jQuery(".multi-pager .icon.current").attr("data-for")).addClass("current");
}

jQuery(document).ready(function ($) {
    if ($(".multi-pager").length > 0) {
        $(".multi-pager .pager-icons .icon[data-for=\"page-1\"]").addClass("current");
        $(".multi-pager .page-1").addClass("current");
        $(".multi-pager .page").css("width", ($(".multi-pager").width() - $(".multi-pager .pager-icons").width() - 1) + "px");
        interval = setInterval(multipager_slide, 8000);

        $(".multi-pager .icon").on("click", function () {
            clearInterval(interval);
            $(".multi-pager .current").removeClass("current");
            $(this).addClass("current");
            $(".multi-pager ." + $(this).attr("data-for")).addClass("current");
            interval = setInterval(multipager_slide, 8000);
        });
    }
});