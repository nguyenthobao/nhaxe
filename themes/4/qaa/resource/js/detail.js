var faq = function(e) {

	var initComponents = function(e) {
		//CKEDITOR.replace('answer_editor');
		$('.showAsw').click(function(){
        if($('.giveanswer').is(":visible")) $('.giveanswer').hide(); else $('.giveanswer').show();
        $('.f-qa-answer-box').slideToggle();
    	});
		$("#f5capt").click(function() {
		$("#cap").val(0);
		d = new Date();
		var src = $("#capt_img").attr("src");
		$("#capt_img").attr("src", src+'?'+d.getTime());
		});
		$('#captcha').keyup(function(){
	    $.ajax({
	        url: e['check_captcha_url'],
	        type: 'POST',
	        data:{captcha:$(this).val()},
	        success:function(data) {    
	            $("#cap").val(data);
	        }
	    });
	    });
		}
	var validateEmail = function (sEmail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(sEmail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
		}  

	return {
		//main function to initiate the module
		init: function(e){
			initComponents(e);
		},
		like: function (e) {//like, unlike, denounce, useful
		e['ajaxElement'].click(function() {//select element
		var $this = $(this);
		var display = $(this).find("b");
		var id_ = $(this).attr('data-id');
		var id_ = $(this).attr('data-id');
		var type_ = $(this).attr('data-type');
		var datafld_ = $(this).attr('datafld');
		if(id_){
		if(!e["uid"]){
		BootstrapDialog.alert({
        title: e['alert'],
        message: e['please_log_in_to_perform_this']
    	});
		return false;
		}
		if(type_=='like' || type_=='unlike'){
		$("#like"+id_+datafld_).find(".like").html('<img src="'+e["imgLoading"]+'"/>');
		$("#unlike"+id_+datafld_).find(".unlike").html('<img src="'+e["imgLoading"]+'"/>');
		}else if(type_=='denounce'){
		$this.find(".denounce").html('<img src="'+e["imgLoading"]+'"/>');
		}else if(type_=='useful'){
		$this.html('<img src="'+e["imgLoading"]+'"/>');
		$('.useful'+e["id_question"]).addClass('tmp'+e["id_question"]);
		}
		$.post(e["url"], { id: id_, type: type_, datafld: datafld_ }, function(data) {
		if(data.type=='like'){//like button click
		display.html('('+data.good+')');
		$("#unlike"+id_+datafld_).find("b").html('('+data.bad+')');
		if(data.like){
		$("#like"+id_+datafld_).find(".like").html(e["liked"]);
		}else{
		$("#like"+id_+datafld_).find(".like").html(e["like"]);
		}
		$("#unlike"+id_+datafld_).find(".unlike").html(e["not_like"]);
		}else if(data.type=='unlike'){//unlike button click
		display.html('('+data.bad+')');
		$("#like"+id_+datafld_).find("b").html('('+data.good+')');
		$("#like"+id_+datafld_).find(".like").html(e["like"]);
		if(data.unlike){
		$("#unlike"+id_+datafld_).find(".unlike").html(e["not_liked"]);
		}else{
		$("#unlike"+id_+datafld_).find(".unlike").html(e["not_like"]);
		}
		}else if(data.type=='useful'){//useful button click
		$this.removeClass('tmp'+e["id_question"]);
		$this.html('<img src="'+e["imgCheck"]+'"/>');
		$this.attr('title',e["The_question_choose_the_best_answer"]);
		$('.tmp'+e["id_question"]).remove();
		}else{
		$this.find(".denounce").html(data.denounce_text);
		}
		}, "json");
		}
		});
		},
		answer: function (e, form, l) {
			if($.trim(form.answer_editor.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_text']
	        	});
				return false;
			}
			if($.trim(form.answer_name.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_a_name']
	        	});
				return false;
			}
			var email = validateEmail(form.email.value);
			if ($.trim(form.email.value).length == 0) {
 	            BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_a_valid_email_address']
	        	});
 	            return false;
 	        }
			if(!email){
			BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['email_address_is_not_valid']
	        	});
				return false;
			}
			if($("#cap").val()==0){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_the_correct_security_code']
	        	});
				return false;
			}
			//
			$.post(l["url_answer"], {answer:form.answer_editor.value, name:form.answer_name.value, email:form.email.value, id:l['id_question']}, function(data) {
			if(data.success){
			$("#cap").val(0);
			CKEDITOR.instances.answer_editor.setData('');
			form.answer_editor.value=form.answer_name.value=form.email.value='';
			$( ".showAsw, #f5capt" ).trigger( "click" );
			}
			}, "json");
		}//end submitForm​
	};

}(); 

