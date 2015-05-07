$(function(){
    var $form = $(".signup form");
    if (!Modernizr.input.required || !Modernizr.formvalidation)
    {
        $form.validate({
            submitHandler : onsubmit
        });
    }
    else
    {
        $form.on("submit", onsubmit);
    }
    
    function onsubmit(form)
    {
        $.post("signup.php", $(form).serialize());
        $(form).html("<p>Thank you! [INSERT CONTENT HERE]</p>");
        return false;
    }
});
