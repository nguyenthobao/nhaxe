var Editaddress = function(){
	var getDistrict  =function(){
        $('.provinces').change(function(){
            var url_ajax = $('body').data('home_url')+'/product-userManager-getDistrict'+$('body').data('extension');
            $('#show_district').hide();
            var id_tinh =$(this).val();
            var defaultoption ="Chọn quận huyện";
                $.ajax({
                            url: url_ajax, 
                            type: 'POST',
                            dataType: 'json',
                            data: {action:'getDistrict',id_tinh:id_tinh},
                            success: function(data){
                                $('.districtid').html('<option value="0">'+defaultoption+'</option>');
                                $.each( data, function( key, value ) {
                                    var html= '<option value="'+value.districtid+"-"+value.name+'">'+value.name+'</option>';
                                    $('.districtid').append(html);
                                });
                                $('#show_district').show();
                                console.log(data);
                            }
                        });
            });
    }

	
	return {
		init: function () {
			getDistrict();
		}
	};

}();