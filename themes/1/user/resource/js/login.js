
var Login = function () {

    var handleValidation = function(){
        $('.btn-primary').click(function(){

          	var name     = $('#txtname').val();
          	var password = $('#txtpassword').val();

            $('#txtname').live('keypress',function(){
                var name = $('#txtname').val();
                length =name.length;
                if(length>0){
            	    $("#nameError").slideUp('slow');
        	    }
        	})
            
        	if(name == "") {
                $("#nameError").slideDown('slow');
                $("#txtname").focus();
               	return false;
          	}else{ $("#nameError").slideUp('slow');}; 

      
         	$('#txtpassword').live('keypress',function(){
           		var name = $('#txtpassword').val();
           		length =name.length;
           		if(length>0){
            		$("#passwordError").slideUp('slow');
         		}
        	})

        	if(password == ""){
          		$("#passwordError").slideDown('slow');
           		$("#txtpassword").focus()
           		return false;
        	}else{
          		$("#passwordError").slideUp('slow');
        	};
        });

  			$('.email').live('keypress',function(){
           		var name= $('.email').val();
           		length=name.length;
           		if(length>0){
            		$("#emailNull").slideUp('slow');
            		$("#emailError").slideUp('slow');
         		}
        	});
        	$('#name').live('keypress',function(){
           		var name = $('#name').val();
           		length = name.length;
           		if(length>0){
            		$(".name_Error").slideUp('slow');
        	 	}
        	})
        	$('#password').live('keypress',function(){
           		var name = $('#password').val();
           		length =name.length;
           		if(length>0){
            		$("#password_Error").slideUp('slow');
         		}
             if(length>5){
                $("#password_short").slideUp('slow');
            }
       		})
       		$('#repassword').live('keypress',function(){
           		var name = $('#repassword').val();
           		length =name.length;
           		if(length>0){
            		$("#repasswordError").slideUp('slow');
         		}
           
       		})
      	$('.btn-success').click(function(){
            var check_macapcha =$("#cap_md").val();
      	     var email       = $('.email').val();
            var name        = $('#name').val();
            var password    = $('#password').val();
            var length      = password.length;
            var repassword 	= $('#repassword').val();
            var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

            //check mail
          	if(email==""){
            	$("#emailNull").slideDown('slow');
            	$("#emailError").slideUp('slow');
           		$(".email").focus();
           		return false;
          	}
          	if(!email_regex.test(email)) {
           		$("#emailError").slideDown('slow');
          		$("#email").focus();
           		return false;
        	}else{
          		$("#emailError").slideUp('slow');
        	};
        	//check name
        	if(name == "") {
               	$(".name_Error").slideDown('slow');
               	$("#name").focus();
               	return false;
          	}else{ $(".name_Error").slideUp('slow');}; 

            if (length<6&&length>0) {
                $("#password_short").slideDown('slow');
                $("#password").focus();
                return false;
          }else{
                $("#password_short").slideUp('slow');
          }
          	//check password
        	if(password == ""){
          		$("#password_Error").slideDown('slow');
          		$("#password").focus();
           		return false;
        	}else if(repassword == ""){
          		$("#repasswordError").slideDown('slow');
          		$("#repassword").focus();
           		return false;
           	}else if(password != repassword ){
           		$("#changepasswordError").slideDown('slow');
           		$("#repassword").focus();
        		return false;
           	}else if (check_macapcha==0) {
              $('#capchaError').slideDown('slow');
              return false;
            }; 
        });
    }
    var initComponents = function() {
      $("#f5capt_cha").click(function() {
      $("#cap_md").val(0);             
      d = new Date();
      var src = $("#capt_img_ct").attr("src");
        $("#capt_img_ct").attr("src", src+'?'+d.getTime());
      });

      $('#captcha_cha').keyup(function(){
           var url_ajax = $('.check_capcha').attr('check_capcha');
            $.ajax({
                url: url_ajax,
                type: 'POST',
                data:{captcha:$(this).val()},
                success:function(data) {  
                    $("#cap_md").val(data);
                }
            });

        });
      }
    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
            initComponents();
        }
    };

}();