var faq = function(e) {

	var initComponents = function(e) {
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
		CKEDITOR.replace('faq_editor');
		//
		$('#cate_scroll').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            loadCate(e);
        }
   		});
   		$('#search').keyup(function(){
   			searchCate(e, $(this).val());
   		});
	}
	var maxId = function(selector) {
    var min=null, max=null;
    $(selector).each(function() {
        var id = parseInt(this.id, 10);
        if (isNaN(id)) { return; }
        if ((min===null) || (id < min)) { min = id; }
        if ((max===null) || (id > max)) { max = id; }
    });
    return max
	}
	
	var loadCate = function(e) {
    	var ID = maxId('#cate_scroll p');
    	var TITLE = $('#search').val();
        $.ajax({
            url: e['load_cate_url'],
            type: 'POST',
            data:{id:ID, title:TITLE},
            success:function(data) {
                $("#cate_scroll").append(data);          
            }
        });
	}
	var searchCate = function(e,val) {
    	var TITLE = val;
        $.ajax({
            url: e['load_cate_url'],
            type: 'POST',
            data:{title:TITLE},
            success:function(data) {
                $("#cate_scroll").html(data);          
            }
        });
	}
	return {
		//main function to initiate the module
		init: function(e){
			initComponents(e);
		},
		valid: function(e, form, l){
			if($.trim(form.title.value)==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_a_title_question']
	        	});
				return false;
			}
			if($.trim($(CKEDITOR.instances.faq_editor.getData()).text())==''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_enter_the_text_questions']
	        	});
				return false;
			}

			if($('input[name=category_id]:checked').val() == ''){
				BootstrapDialog.alert({
	            title: l['alert'],
	            message: l['please_select_the_category_that_question']
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
			e.submit();
		}
	};

}(); 
