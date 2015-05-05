$(function(){
    $(".signup form").on("submit", onsubmit);
    
    function onsubmit()
    {
        $.post("signup.php", $(this).serialize());
        $(this).html("<p>Thank you! [INSERT CONTENT HERE]</p>");
        return false;
    }
});