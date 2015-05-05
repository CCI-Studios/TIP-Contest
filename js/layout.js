$(function(){
    initSnap();
    resize();
    $(window).on("load resize", resize);
    $(".scroll a").on("click", scrollDown);
    
    
    function resize()
    {
        var h = $(window).height() - 175;
        $(".section").css("min-height",h+"px").find("> div > div").each(function(){
            var p = (h - $(this).height() - 80) / 2;
            $(this).css("padding", p+"px 0");
        });
        
        if ($(window).width() >= 720)
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
        var top = $(".section2").position().top - 175;
        $("html, body").animate({
            scrollTop: top+"px"
        });
        return false;
    }
    
    function initSnap()
    {
        $("body").panelSnap({
            panelSelector: ".section",
            offset: 175,
            keyboardNavigation: {
                enabled: true
            },
            directionThreshold: 250,
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
});
