var User = function () {
	   
     var handleDatePickers = function () {
        if (jQuery().datepicker) {
            $('.form_datetime').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true
            });  
        }
    }

    var getDistrict  =function(){
        $('.provinces').change(function(){
            var url_ajax= $('#url_ajax').val();
            $('#show_district').hide();
            var id_tinh =$(this).val();
            var defaultoption =$('.districtid').attr('data-defaultoption');
                $.ajax({
                            url: url_ajax, 
                            type: 'POST',
                            dataType: 'json',
                            data: {action:'getDistrict',id_tinh:id_tinh},
                            success: function(data){
                                $('.districtid').html('<option value="0">'+defaultoption+'</option>');
                                $.each( data, function( key, value ) {
                                    var html= '<option value="'+value.districtid+'">'+value.name+'</option>';
                                    $('.districtid').append(html);
                                });
                                $('#show_district').show();
                                console.log(data);
                            }
                        });
            });
    }

/*    var editGetdistrict = function(){
        var key = $('.get_id_province').attr('key');
        var keyd = $('.show_district').attr('keyd');
        alert(keyd);
        var url_ajax= $('#url_ajax').val();
            $('#show_district').hide();
            var id_tinh = key;
            if(id_tinh>0){
            var defaultoption =$('.districtid').attr('data-defaultoption');
                $.ajax({
                            url: url_ajax, 
                            type: 'POST',
                            dataType: 'json',
                            data: {action:'getDistrict',id_tinh:id_tinh},
                            success: function(data){
                                $('.districtid').html('<option value="0">'+defaultoption+'</option>');
                                $.each( data, function( key, value ) {
                                    var html= '<option value="'+value.districtid+'">'+value.name+'</option>';
                                    $('.districtid').append(html);
                                });
                                $('#show_district').show();
                                console.log(data);
                            }
                        });
            }
    }*/

 return {
        //main function to initiate the module
        init: function () {
            handleDatePickers();
            getDistrict();
            //editGetdistrict();
        }
    };

}();