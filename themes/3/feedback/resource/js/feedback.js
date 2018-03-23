
var Feedback = function () {
    var cencer =function(){
        $('#btnCancel').click(function(){
            $("#nameError").slideUp('slow');
            $("#emailError").slideUp('slow');
            $("#contentError").slideUp('slow');
            $("#emailNull").slideUp('slow');
            $('#capcha_feedback_Error').slideUp('slow');
      })
    }

    var checkmail =function(){
      var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

      $('#txtAddress').mousedown(function(){
        var email= $('#txtEmail').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
              
               $("#emailError").slideDown('slow');
               $("#txtEmail").focus();
        }else{
          $("#emailError").slideUp('slow');
        };
        }
      });
      $('#txtContent').mousedown(function(){
            var email= $('#txtEmail').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
     
               $("#emailError").slideDown('slow');
               $("#txtEmail").focus();
        }else{
          $("#emailError").slideUp('slow');
        };
        }

      });
    }
    var handleValidation =function(){
            $('#btnSent').click(function(){
          var check_macapcha =$("#cap_feedback_md").val();
          var name= $('#txtName').val();
          var email= $('#txtEmail').val();
          var content =$('#txtContent').val();
          var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
          
          $('#txtName').live('keypress',function(){
           var name= $('#txtName').val();
           length=name.length;
           if(length>0){
            $("#nameError").slideUp('slow');
         }
        })
            
           if(name == "") {
               $("#nameError").slideDown('slow');
               $("#txtName").focus();
               
               return false;
          }else{ $("#nameError").slideUp('slow');};

          //check email
           $('#txtEmail').live('keypress',function(){
           var name= $('#txtEmail').val();
           length=name.length;
           if(length>0){
            $("#emailNull").slideUp('slow');
            $("#emailError").slideUp('slow');
         }
        })

          if(email==""){
            $("#emailNull").slideDown('slow');
            $("#emailError").slideUp('slow');
           $("#txtEmail").focus()
           return false;
          }
          if(!email_regex.test(email)) {
           $("#emailError").slideDown('slow');
           $("#txtEmail").focus()
           return false;
        }else{
          $("#emailError").slideUp('slow');
        };
      
         $('#txtContent').live('keypress',function(){
           var name= $('#txtContent').val();
           length=name.length;
           if(length>0){
            $("#contentError").slideUp('slow');
         }
        })
        if(content == ""){
          $("#contentError").slideDown('slow');
           $("#txtContent").focus()
           return false;
        }else{
          $("#contentError").slideUp('slow');
        };
        if(check_macapcha==0){
          $('#capcha_feedback_Error').slideDown('slow');
        return false;
      }
         
        });
    }
    var initComponents = function() {
        $("#f5capt_feedback_cha").click(function() {
        $("#cap_feedback_md").val(0);
       
                       
        d = new Date();
        var src = $("#capt_feedback_img_ct").attr("src");
        $("#capt_feedback_img_ct").attr("src", src+'?'+d.getTime());
        });

        $('#captcha_feedback_cha').keyup(function(){
           var url_ajax = $('.check_feedback_capcha').attr('check_capcha');
            $.ajax({
                url: url_ajax,
                type: 'POST',
                data:{captcha:$(this).val()},
                success:function(data) {  
                    $("#cap_feedback_md").val(data);
                }
            });

        });
      }
 
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            handleValidation();
            cencer();
            checkmail();
        }
    };

}();