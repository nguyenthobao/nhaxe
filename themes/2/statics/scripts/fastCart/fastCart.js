$("#fast-cart").validationEngine("attach", {
    promptPosition: "bottomLeft",
    scroll: false,
    onValidationComplete: function(form, status) { // when validate is on and the form scan is completed
        if (status == true) { // equiv to success everythings is OK
            var urlHome = $('body').data('home_url');
            var ext = $('body').data('extension');
            var input_invoice = $('input#invoice');
            var input_email = $('input#email');
           
            var dataString = {
                'invoice': input_invoice.val(),
                'email': input_email.val()
            };
            var urlSend = urlHome + '/product-fastCart-ajaxCheckInvoice' + ext;
            $.getJSON(urlSend, dataString)
                .done(function(msg) {
                    if (msg.status == false) {
                        $('#notify-fast-cart').html(msg.msg);
                        $('#alert-fast-cart').show();
                        return false;
                    } else {
                        window.location.href = msg.msg;
                    }
                })
                .fail(function(jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    console.log("Request Failed: " + err);
                });
            return false; // we disable the default from action to make our own action like alert or other function

        } else {

        }
    }


});