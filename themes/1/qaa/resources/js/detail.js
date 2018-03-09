var faq = function(e) {

	var initComponents = function(e) {
		CKEDITOR.replace('answer_editor');
		$('.showAsw').click(function(){
        if($('.giveanswer').is(":visible")) $('.giveanswer').hide(); else $('.giveanswer').show();
        $('.f-qa-answer-box').toggle("slow", "linear");
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

	return {
		//main function to initiate the module
		init: function(e){
			initComponents(e);
		},
		valid: function(e, form, l){
			if(form.title.value==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_ten']
	        	});
				return false;
			}
			if(CKEDITOR.instances.faq_editor.getData()==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_noi_dung']
	        	});
				return false;
			}
			if(form.category_id.value==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_danh_muc']
	        	});
				return false;
			}
			if($("#cap").val()==0){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_dung_captcha']
	        	});
				return false;
			}
			e.submit();
		}
	};

}(); 
