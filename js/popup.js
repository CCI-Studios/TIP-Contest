$(function(){
    $(".popup").append("<a href='#' class='close' title='Close'>Close</a>");
    $(".popup").on("click", ".close", close);
    $(".popup-overlay").on("click", close);
    $(".popup-link").on("click", popupLinkClick);
    
    function popupLinkClick()
    {
        open($(this).data("popup"));
        return false;
    }
    
    function open(popupName)
    {
        $(".popup."+popupName).fadeIn(800).find("input").first().focus();
        openOverlay();
    }
    function close()
    {
        $(".popup").fadeOut(200);
        closeOverlay();
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
});