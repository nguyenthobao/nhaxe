var blockFeedback = function () {

    var cencerBlock = function(){
      $('#fbcancel').click(function(){
            $("#name_fb_Error").slideUp('slow');
            $("#email_fb_Error").slideUp('slow');
            $("#address_fb_Error").slideUp('slow');
            $("#content_fb_Error").slideUp('slow');
            $("#email_fb_Null").slideUp('slow');
      })
    }
    var checkmail =function(){
      var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

      $('#address_fb_block').mousedown(function(){
        var email= $('#email_fb_block').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
              $("#email_fb_Null").slideUp('slow');
               $("#email_fb_Error").slideDown('slow');
               $("#email_fb_block").focus();
        }else{
          $("#email_fb_Error").slideUp('slow');
        };
        }
      });
      $('#content_fb_block').mousedown(function(){
            var email= $('#email_fb_block').val();
        length=email.length;
        if(length>0){
          if(!email_regex.test(email) || email == "") {
              $("#email_fb_Null").slideUp('slow');
               $("#email_fb_Error").slideDown('slow');
               $("#email_fb_block").focus();
        }else{
          $("#email_fb_Error").slideUp('slow');
        };
        }

      });
    }
    var handleValidationBlock =function(){
      $('#fbsubmit').click(function(){

          var name= $('#name_fb_block').val();
          var email= $('#email_fb_block').val();
          var content =$('#content_fb_block').val();
          var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

          $('#name_fb_block').live('keypress',function(){
           var name= $('#name_fb_block').val();
           length=name.length;
           if(length>0){
              $("#name_fb_Error").slideUp('slow');
         }
        })
           if(name == "") {
           $("#name_fb_Error").slideDown('slow');
           $("#name_fb_block").focus();
           return false;
        }else{ $("#name_fb_Error").slideUp('slow');};

         $('#email_fb_block').live('keypress',function(){
           var name= $('#email_fb_block').val();
           length=name.length;
           if(length>0){
            $("#email_fb_Null").slideUp('slow');
            $("#email_fb_Error").slideUp('slow');
         }
        })
         if(email==""){
            $("#email_fb_Null").slideDown('slow');
            $("#email_fb_Error").slideUp('slow');
           $("#email_fb_block").focus()
           return false;
          }
          if(!email_regex.test(email) || email == "") {
           $("#email_fb_Error").slideDown('slow');
           $("#email_fb_block").focus()
           return false;
        }else{
          $("#email_fb_Error").slideUp('slow');
        };
     

         $('#content_fb_block').live('keypress',function(){
           var name= $('#content_fb_block').val();
           length=name.length;
           if(length>0){
            $("#content_fb_Error").slideUp('slow');
         }
        })
        if(content == ""){
          $("#content_fb_Error").slideDown('slow');
           $("#content_fb_block").focus()
           return false;
        }else{
          $("#content_fb_Error").slideUp('slow');
        };
         
        });

    }

    
    return {
        //main function to initiate the module
        init: function () {
            cencerBlock();
            handleValidationBlock();
            checkmail();
        }
    };

}();