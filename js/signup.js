$(function(){
    var $form = $(".signup form");
    if (!Modernizr.input.required || !Modernizr.formvalidation)
    {
        $form.validate({
            submitHandler: onsubmit,
            errorPlacement: errorPlacement,
            rules: {
                date_of_birth: {
                    dateISO: true
                }
            }
        });
    }
    else
    {
        $form.on("submit", onvalidatesubmit);
    }
    
    function onvalidatesubmit()
    {
        return onsubmit(this);
    }
    function onsubmit(form)
    {
        $.post("signup.php", $(form).serialize(), function(response){
            if (response.error && response.error == "email")
            {
                if ($("html").attr("lang") == "en")
                {
                    $(form).html("<p>This email address has alreay been registered.</p>");
                }
                else
                {
                    $(form).html("<p>FRANCAIS FRANCAIS This email address has alreay been registered.</p>");
                }
            }
            else
            {
                $(form).html("<p>Thank you! Merci!</p>");
            }
        }, "json");
        $(form).html("<p>Working...</p>");
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
