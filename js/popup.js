$(function(){
    $(".popup").append("<a href='#' class='close' title='Close'>Close</a>");
    $(".popup").on("click", ".close", close);
    $(".popup-overlay").on("click", close);
    $(".popup-link").on("click", popupLinkClick);
    $(window).on("resize", resizeSignup);
    
    function popupLinkClick()
    {
        open($(this).data("popup"));
        return false;
    }
    
    function open(popupName)
    {
        $(".popup."+popupName).fadeIn(800).find("input").first().focus();
        openOverlay();
        $("body").panelSnap('disable');
        resizeSignup();
    }
    function close()
    {
        $(".popup").fadeOut(200);
        closeOverlay();
        $("body").panelSnap('enable');
        return false;
    }
    function openOverlay()
    {
        $(".popup-overlay").fadeIn(400);
    }
    function closeOverlay()
    {
        $(".popup-overlay").fadeOut(200);
    }
    
    function resizeSignup()
    {
        if ($(".signup").outerHeight() > $(window).height())
        {
            $(".signup").addClass("absolute");
        }
        else
        {
            $(".signup").removeClass("absolute");
        }
    }
});
