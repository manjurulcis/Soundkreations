jQuery(document).ready(function ($) {
    if ($(".notification").length !== 0) {
        setTimeout(function () {
            var height = $(".notification").css("height", "auto").height();
            $(".notification").css("height", "0").animate({ 'height': (height + 30) + "px", 'padding': '15px 2%' }, 500);
            if ($("#wpadminbar").length > 0) {
                $(".notification").css("top", $("#wpadminbar").height() + "px");
            }
            
            // note - variables intentionally left seperate to distinguish between "natural" top and padding top
            if ($(".home").length > 0) {
                $("#header").animate({ "top": (height + 30 + 25) + "px" }, 500);
            }
            // compensate for notification bar
            $("#wrap_all").animate({ "margin-top": (height + 29) + "px" }, 500);
        }, 500);

        $(".notification").on("click", function () {
            $(".notification").animate({ 'height': '0', 'padding': '0 2%' }, 500);
            $("#wrap_all").animate({ "margin-top": "0" });
            if ($(".home").length > 0) {
                $("#header").animate({ "top": "25px" }, 500);
                $(".header-questions").animate({ "top": "-25px" }, 500);
            }
        });
    }

    $("#top #footer .gform_wrapper .gfield").each(function () {
        var html = $("label", this).html();
        $("#" + $("label", this).attr("for")).attr("placeholder", html);
    });
    $("#top #footer .gform_wrapper .gform_footer .gform_button").attr("value", "Submit your Message");

    if ($(".home").length > 0) {
        var length = $("#top #header .main_menu .menu .menu-item").length;
        $("#top #header .main_menu .menu .menu-item-top-level").each(function (index) {
            console.log(index);
            if (index == 3) {
                $(this).addClass("marginleft");
            }
        });
    }
});