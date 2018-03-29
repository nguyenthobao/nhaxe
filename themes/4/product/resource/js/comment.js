	var username          = $('#username').val();
	var email_user        = $('#email_user').val();
	if (username != '') {
		$('#name_cmt').val(username);
		$('#email_cmt').val(email_user);
	};
	

	$('body').on('click', '.row_btn_reply', function(event) {
		event.preventDefault();
		var formReply=$('#RootFormReply').clone();
		var Rparents=$(this).parents('.col-md-11');
		var id=$(this).attr('data-id');

		//Remove sub
		$('.formReply').slideUp();
		Rparents.find('.subReply').html('');
		Rparents.find('.subReply').html(formReply);
		Rparents.find('.formReply').removeAttr('id').css({
			display: 'none'
		});
		Rparents.find('.formReply').slideDown();
		if (username != '') {
			Rparents.find('#name_cmt').val(username);
			Rparents.find('#email_cmt').val(email_user);
			Rparents.find('#comment').val('');
		}else {
			Rparents.find('#name_cmt').val('');
			Rparents.find('#email_cmt').val('');
			Rparents.find('#comment').val('');
		}
		//parents.append(formReply);
		Rparents.find('#id_parent').val(id);
			
	});
	$('body').on('click', '.BNC-comment-product', function(event) {
		var id          = $(this).attr('data-id');
		var name        = $('#name_cmt').val();
		var email       = $('#email_cmt').val();
		var comment     = $('#comment').val();
		var id_product  = $('#id_product').val();
		var parent      = $('#id_parent').val();

		var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
		if(name == "") {
			alert("Tên không được để trống");
			return false;
	   	}
	    if(email == "" || !email_regex.test(email)) {
			alert("Email không đúng hoặc sai định dạng");
			return false;
	   	}
	    $.ajax({
	      	type: "POST",
	      	url: $('base').attr('href')+"/product-product-sendComment.html",
	      	data: {name:name, email:email, comment:comment, id_product:id_product, parent:parent},
	      	success: function(){
	        	alert('Bạn đã gửi comment sản phẩm thành công!');
	        	$('#name_cmt').val('');
	        	$('#email_cmt').val('');
	        	$('#comment').val('');
	        	window.location.reload(true);
	      	}
	    });
	});
	$('body').on('click', '.btn_bao_cao', function(event) {
		var id          = $(this).attr('data-id');
	    $.ajax({
	      	type: "POST",
	      	url: $('base').attr('href')+"/product-product-updateFlag.html",
	      	data: {id:id},
	      	success: function(){
	        	alert('Bạn đã gửi báo cáo vi phạm của comment này!');
	        	window.location.reload(true);
	      	}
	    });
	});