var catego = function () {
    var initComponents = function () {
        //init maxlength handler
        $('.maxlength-handler').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            threshold: 5
        });
    }
     var handleSelectLang = function () {
        $('.select_lang').click(function(){
            var exists        = $(this).attr('data-exists');
            var alert_title   = $(this).attr('data-title');
            var alert_message = $(this).attr('data-message');
            var close         = $(this).attr('data-close');
            if(exists == 'notExist') {
                bootbox.dialog({
                    message: alert_message,
                    title: alert_title,
                    buttons: {
                        danger: {
                            label: close,
                            className: "blue",
                            callback: function() {
                                return;
                            }
                        }
                    }
                });
                return false;
            }
        });
    }
    var handleValidationcatego = function() {
            var form_catego = $('#form_catego');
            var error1 = $('.alert-danger', form_catego);
            var success1 = $('.alert-success', form_catego);
            $('.continue').click(function(){
                var con = $(this).attr('data-continue');
                $('input[name="continue"]').val(con);
            });

            form_catego.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    title: {
                        required: $('input[name="title"]').attr('data-error'),
                    },
                    
                  
                },
                rules: {
                    title: {
                        minlength: 3,
                        required: true
                    },
                    
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    Metronic.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group

                },

                submitHandler: function (form) {
                    form.submit();
                    error1.hide();
                }
            });
    }
    var handleTagsInput = function () {
        if (!jQuery().tagsInput) {
            return;
        }
        $('input[name="meta_keyword"]').tagsInput({
            width: 'auto',
            'onAddTag': function () {
                //alert(1);
            },
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            handleTagsInput();
            handleValidationcatego();
            handleSelectLang();
        }
    };

}();