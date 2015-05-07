$(function(){
    initSnap();
    resize();
    $(window).on("load resize", resize);
    $(".scroll a").on("click", scrollDown);
    $(".menu a").on("click", menuClick)
    
    function resize()
    {
        var h = $(window).height() - 150;
        $(".section").css("min-height",h+"px").find("> div > div").each(function(){
            var p = (h - $(this).height() - 80) / 2;
            $(this).css("padding", p+"px 0");
        });
        
        if ($(window).width() > 768 && $(window).height() > 768)
        {
            enableSnap();
        }
        else
        {
            disableSnap();
        }
    }
    function scrollDown()
    {
        var top = $(".section2").position().top - 150;
        $("html, body").animate({
            scrollTop: top+"px"
        });
        return false;
    }
    
    function initSnap()
    {
        $("body").panelSnap({
            panelSelector: ".section",
            offset: 150,
            keyboardNavigation: {
                enabled: true
            },
            directionThreshold: 180,
            easing: 'swing',
            slideSpeed: 300
        });
    }
    function enableSnap()
    {
        $("body").panelSnap('enable');
    }
    function disableSnap()
    {
        $("body").panelSnap('disable');
    }
    
    function menuClick()
    {
        if ($(this).attr("href").charAt(0) == '#')
        {
            var top = $("#"+$(this).attr("href").substr(1)).offset().top - parseInt($(".page-wrapper").css("padding-top"));
            if (top == 0 && $("body").scrollTop() == 0)
            {
                top = 50;
            }
            $("html, body").animate({
                scrollTop: top+"px"
            }, 400);
            return false;
        }
    }
});
