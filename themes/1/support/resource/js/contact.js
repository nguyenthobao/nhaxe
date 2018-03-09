
var Contact = function () {
    var cencer =function(){
        $('#btnCancel').click(function(){
            $("#nameError").slideUp('slow');
            $("#phoneError").slideUp('slow');
            $("#emailError").slideUp('slow');
            $("#emailNull").slideUp('slow');
            $("#addressError").slideUp('slow');
            $("#contentError").slideUp('slow');
      })

    }
    var cencerBlock = function(){
      $('#huy').click(function(){
            $("#name_Error").slideUp('slow');
            $("#phone_Error").slideUp('slow');
            $("#email_Error").slideUp('slow');
            $("#address_Error").slideUp('slow');
            $("#content_Error").slideUp('slow');
            $("#email_Null").slideUp('slow');
      })
    }
    var checkmailblock =function(){
      var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

      $('#address_block').mousedown(function(){
        var email= $('#email_block').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
              
               $("#email_Error").slideDown('slow');
               $("#email_block").focus();
        }else{
          $("#emailError").slideUp('slow');
        };
        }
      });
      $('#content_block').mousedown(function(){
            var email= $('#email_block').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
     
               $("#email_Error").slideDown('slow');
               $("#email_block").focus();
        }else{
          $("#emailError").slideUp('slow');
        };
        }

      });
    }
    var handleValidationBlock =function(){
      $('#gui').click(function(){

          var name= $('#name_block').val();
          var phone= $('#phone_block').val();
          var email= $('#email_block').val();
          var address= $('#address_block').val();
          var content =$('#content_block').val();
          var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

          $('#name_block').live('keypress',function(){
           var name= $('#name_block').val();
           length=name.length;
           if(length>0){
              $("#name_Error").slideUp('slow');
         }
        })
           if(name == "") {
           $("#name_Error").slideDown('slow');
           $("#name_block").focus();
           return false;
        }else{ $("#name_Error").slideUp('slow');};

         $('#phone_block').live('keypress',function(){
           var name= $('#phone_block').val();
           length=name.length;
           if(length>0){
            $("#phone_Error").slideUp('slow');
         }
        })
       
        if (phone == "") {
          $("#phone_Error").slideDown('slow');
           $("#phone_block").focus()
           return false;
        }else{
          $("#phone_Error").slideUp('slow');
        };
         $('#phone_block').live('keypress',function(){
           var name= $('#phone_block').val();
           length=name.length;
           if(length>0){
            $("#phone_Error").slideUp('slow');
         }
        })
         $('#email_block').live('keypress',function(){
           var name= $('#email_block').val();
           length=name.length;
           if(length>0){
            $("#email_Error").slideUp('slow');
             $("#email_Null").slideUp('slow');
         }
        })
           if(email==""){
            $("#email_Error").slideUp('slow');
            $("#email_Null").slideDown('slow');
           $("#email_block").focus()
           return false;
          }
          if(!email_regex.test(email) || email == "") {
           $("#email_Error").slideDown('slow');
           $("#email_block").focus()
           return false;
        }else{
          $("#email_Error").slideUp('slow');
        };
        $('#address_block').live('keypress',function(){
           var name= $('#address_block').val();
           length=name.length;
           if(length>0){
            $("#address_Error").slideUp('slow');
         }
        })
        if(address == ""){
          $("#address_Error").slideDown('slow');
           $("#address_block").focus()
           return false;
        }else{
          $("#address_Error").slideUp('slow');
        };

         $('#content_block').live('keypress',function(){
           var name= $('#content_block').val();
           length=name.length;
           if(length>0){
            $("#content_Error").slideUp('slow');
         }
        })
        if(content == ""){
          $("#content_Error").slideDown('slow');
           $("#content_block").focus()
           return false;
        }else{
          $("#content_Error").slideUp('slow');
        };
         
        });

    }
    var checkmail =function(){
      var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

      $('#txtAddress').mousedown(function(){
        var email= $('#txtEmail').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
              
               $("#emailError").slideDown('slow');
               $("#email").focus();
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
               $("#email").focus();
        }else{
          $("#emailError").slideUp('slow');
        };
        }

      });
    }
    var handleValidation =function(){
            $('#btnSent').click(function(){

          var name= $('#txtName').val();
          var phone= $('#txtPhone').val();
          var email= $('#txtEmail').val();
          var address= $('#txtAddress').val();
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
         $('#txtPhone').live('keypress',function(){
           var name= $('#txtPhone').val();
           length=name.length;
           if(length>0){
            $("#phoneError").slideUp('slow');
         }
        })
       
        if (phone == "") {
          $("#phoneError").slideDown('slow');
           $("#txtPhone").focus();
           return false;
        }else{
          $("#phoneError").slideUp('slow');
        };
         $('#txtPhone').live('keypress',function(){
           var name= $('#txtPhone').val();
           length=name.length;
           if(length>0){
            $("#phoneError").slideUp('slow');
         }
        })
  
         $('#txtEmail').live('keypress',function(){
           var name= $('#txtEmail').val();
           length=name.length;
           if(length>0){
            $("#emailNull").slideUp('slow');
            
         }
        })

          if(email==""){
            $("#emailError").slideUp('slow');
            $("#emailNull").slideDown('slow');
           $("#email").focus()
           return false;
          }
          if(!email_regex.test(email)) {
           $("#emailError").slideDown('slow');
           $("#txtEmail").focus();
           return false;
        }else{
          $("#emailError").slideUp('slow');
        };
        $('#txtAddress').live('keypress',function(){
           var name= $('#txtAddress').val();
           length=name.length;
           if(length>0){
            $("#addressError").slideUp('slow');
         }
        })
        if(address == ""){
          $("#addressError").slideDown('slow');
           $("#txtAddress").focus();
           return false;
        }else{
          $("#addressError").slideUp('slow');
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
           $("#txtContent").focus();
           return false;
        }else{
          $("#contentError").slideUp('slow');
        };
         
        });
    }
 
    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
            cencer();
            cencerBlock();
            handleValidationBlock();
            checkmail();
            checkmailblock();
        }
    };

}();