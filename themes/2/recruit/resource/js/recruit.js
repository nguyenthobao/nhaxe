var recruit = function(e) {
jQuery.fn.numericOnly =
function()
{
    return this.each(function()
    {
        $(this).keyup(function () {     
	  	this.value = this.value.replace(/[^0-9]/g,'');
	});
    });
};
	var getExtension = function (filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
	}
	
	var allow = function (filename) {
	    var ext = getExtension(filename);
	    switch (ext.toLowerCase()) {
	    case 'doc':
	    case 'xls':
	    case 'xlsx':
	    case 'csv':
	    case 'txt':
	    case 'rtf':
	    case 'pdf':
	    case 'docs':
	    case 'docx':
	        //etc
	        return true;
	    }
	    return false;
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

	var initComponents = function(e) {
		$('input[name="phone"]').numericOnly();
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
		$(".app-job-bt").click(function() {
			$(this).hide();
			$(".apply-jod").toggle();
		});
		$('#recruit_limit').change(function(){
			if(this.value!='0'){
			this.form.submit();
			}
		  
		});
	}

	return {
		//main function to initiate the module
		init : function(e) {
			initComponents(e);
		},
		valid: function(e, form, l){
			if($.trim(form.filebutton.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_chon_file']
	        	});
				return false;
			}
			if(!allow(form.filebutton.value)){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['file_khong_hop_le']
	        	});
				return false;
			}
			if($.trim(form.contents_description.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_ta_ve_ban']
	        	});
				return false;
			}
			if($.trim(form.name.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_ten']
	        	});
				return false;
			}
			if($.trim(form.title.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_tieu_de']
	        	});
				return false;
			}
			if($.trim(form.phone.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_sdt']
	        	});
				return false;
			}
			var email = validateEmail(form.email.value);
			if ($.trim(form.email.value).length == 0) {
 	            BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['vui_long_nhap_email']
	        	});
 	            return false;
 	        }
			if(!email){
			BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['dia_chi_email_khong_hop_le']
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

//search form
function q(){
	var q = $('#srch').val();
	if (q=='') {
		alert(per['vui_long_nhap_tu_khoa']);
		return false;
	}
	$('#fsrch').submit();
}
      