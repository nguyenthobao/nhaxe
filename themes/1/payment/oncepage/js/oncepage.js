var OncePage = function(){
	var handlerValidate = function(){
		 var form2 = $('#onePageSubmit');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
		form2.validate({
			errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
			rules: {
				'cus[phone]': {
					required: true,
					minlength: 10,
					maxlength: 14,
					number: true
				},
				'cus[name]': {
					required:true,
					minlength:3,
					maxlength:100,
				},
				'cus[email]': {
					required:true,
					minlength:3,
					email:true
				},
				'cus[cityId]':{
					required:true,
				},
				'cus[districtId]':{
					required:true,
				},
				'cus[address]':{
					required:true,
					minlength:3,
				}
			},
			messages: { // custom messages for radio buttons and checkboxes
                    'cus[email]': {
                        required: "Địa chỉ email",
                        email: "Địa chỉ email nhập dạng có @"
                    },
                    'cus[name]': {
                        required: "Họ tên bạn"
                    },
                    'cus[phone]': {
                        required: "Số điện thoại"
                    },
                    'cus[cityId]': {
                        required: "Chọn Tỉnh/Thành phố",
                    },
                    'cus[districtId]': {
                        required: "Chọn Quận/Huyện"
                    },
                    'cus[address]':{
                    	required: "Vui lòng nhập địa chỉ nhận hàng"
                    }
                },
			invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    //Metronic.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("glyphicon glyphicon-warning-sign");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("glyphicon glyphicon-warning-sign").addClass("glyphicon glyphicon-ok");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                }
		});
	}
	var slimScroll = function(){
		$("#address-Scroll").slimScroll({
		    width: '350px',
		    height: '150px',
		    size: '2px',
		    position: 'right',
		    color: '#333',
		    //alwaysVisible: true,
		    //distance: '20px',
		    //start: $('#child_image_element'),
		    railVisible: true,
		    railColor: '#fff',
		    //railOpacity: 0.3,
		    wheelStep: 3,
		    //allowPageScroll: false,
		    //disableFadeOut: false
		});
	}
	var getDistric = function () {
		var home_url = $('base').attr('href');
        $('.BNC_cityId').change(function(){
        	var district = $(this).parents('.BNC_address_genral').find('.BNC_districtId');
            var provinceid = $(this).val();
            if (provinceid=="") {
            	district.html('<option value="" selected>Quận/Huyện</option>');
                district.prop('disabled',true);
                return false;
            }
            loadding('load');
            $.ajax({
                url: home_url+'/payment-payment-getDistrict.html',
                data:{provinceid:provinceid},
                type:'POST',
                dataType:'json',
                success:function(res){
                    //console.log(res);
                    var html = '<option value="">Quận/Huyện</option>';
                    $.each(res,function(k,v){
                        html += '<option value="'+v.districtid+'">'+v.name+'</option>';
                    });
                    district.html(html);
                    loadding('remove');
                    district.prop("disabled", false);
                },
                error:function (error) {
                    //console.log(error);
                }
            });
        });
	}
    var chooseDistrict = function(){
        var home_url = $('base').attr('href');

        $('.BNC_districtId').change(function(){
            var provinceid;
            var districtid;
            districtid = $(this).val();
            provinceid = $(this).parents('.BNC_address_genral').find('.BNC_cityId').val();
            getListCarrierService(provinceid,districtid);
            $("#methodShipping").slideDown();
        });
    }
    
    var getListCarrierService = function(provinceid,districtid){
        loadding('load');
        var home_url = $('base').attr('href');
        $.ajax({
            url: home_url+'/payment-payment-getShippingMethod.html',
            data:{provinceid:provinceid,districtid:districtid},
            type:'POST',
            dataType:'html',
            success:function(res){
                $("#methodShipping").html(res);
                $('input[name="serviceId"]').addClass('validate[required,serviceId]');
                loadding('remove');
            },
            error:function (error) {
                console.log(error);
            }
        });
    }
    var updateQuantity = function () {
        $('body').on('change','.BNC_product_quantity',function(){
            var home_url = $('base').attr('href');
            var url = home_url+'/payment-oncepage-updateQuantity.html';
            var order_product_id = $(this).attr('order-product-id');
            $.ajax({
                url: url,
                data:{order_product_id:order_product_id,quantity:$(this).val()},
                type:'POST',
                dataType:'json',
                success:function(res){
                    console.log(res);
                    if (res.status==false){
                        alert("Kết nối mạng có vấn đề. Vui lòng thử lại !");
                        return;
                    }
                    $("#BNC_product_list .content").load(home_url+'/payment-oncepage.html #BNC_product_list > .content > *');
                    loadding('remove');
                },
                error:function (error) {
                    console.log(error);
                }
            });
        });
    }
    function globalAjax(url,data,type,dataType){
        var returnObj = new Array();
        $.ajax({
                url: url,
                data:data,
                type:type,
                dataType:dataType,
                success:function(res){
                    returnObj = {status:1,message:res};
                },
                error:function (error) {
                    returnObj = {status:0,message:error};
                }
            });
        return returnObj;
    }
	function loadding (action) {
        if (action=='load') {
            $('#target').loadingOverlay({
              loadingClass: 'loading',          // Class added to target while loading
              overlayClass: 'loading-overlay',  // Class added to overlay (style with CSS)
              spinnerClass: 'loading-spinner',  // Class added to loading overlay spinner
              iconClass: 'loading-icon',        // Class added to loading overlay spinner
              textClass: 'loading-text',        // Class added to loading overlay spinner
              loadingText: 'Vui lòng đợi'            // Text within loading overlay
            });
            
        }else if(action=='remove'){
            $('#target').loadingOverlay('remove', {
              loadingClass: 'loading',
              overlayClass: 'loading-overlay'
            });
        }
    }
	return {
		init:function(){
			handlerValidate();
			slimScroll();
			getDistric();
            chooseDistrict();
            updateQuantity();
		}
	}
}();