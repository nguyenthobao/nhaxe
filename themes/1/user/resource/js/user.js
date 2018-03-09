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
            
            var id_tinh =$(this).val();
            var defaultoption =$('.districtid').attr('data-defaultoption');
                $.ajax({
                            url: url_ajax, 
                            type: 'POST',
                            dataType: 'json',
                            data: {action:'getDistrict',id_tinh:id_tinh},
                            success: function(data){
                                $('.districtid').html('<option value="0">'+defaultoption+'</option>');
                                var html = "";
                                $.each( data, function( k, v ) {
                                    if(k==0){
                                        var select='';
                                    }else{
                                        var select='selected';
                                    }
                                    html += '<option value="'+v.districtid+'" '+select+'>'+v.nhanh_name+'</option>';
                                });
                                $('#show_district select').html(html);
                            }
                        });
            });
    }

 return {
        //main function to initiate the module
        init: function () {
            handleDatePickers();
            getDistrict();
           
        }
    };

}();