$(function(){
    var $form = $(".signup form");
    if (!Modernizr.input.required || !Modernizr.formvalidation)
    {
        $form.validate({
            submitHandler: onsubmit,
            errorPlacement: errorPlacement
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
    function errorPlacement(error, element)
    {
        if (element.attr("type") == "checkbox")
        {
            element.next().after(error);
        }
        else if (element.attr("type") == "date")
        {
            element.after(error);
        }
        else
        {
            element.attr("placeholder", error.text());
        }
    }
});
