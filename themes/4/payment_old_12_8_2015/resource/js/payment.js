var Payment = function (home_url) {
	   
     var getDistric = function (home_url) {
        $('#cityId').change(function(){
            var provinceid = $(this).val();
            $('input[name="methodShipping"]').prop('checked',false);//Bỏ select vận chuyển
            $("#methodShipping").html('');
            //Remove phí ship
            removePriceShip(home_url);
            $('input[name="cus[cityname]"]').val($("#cityId option:selected").attr('name'));
            if (provinceid=="") {
                $('#districtId').html('<option value="" selected>Quận/Huyện</option>');
                $('#districtId').prop('disabled',true);
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
                    $('#districtId').html(html);
                    loadding('remove');
                    $('#districtId').prop("disabled", false);
                },
                error:function (error) {
                    //console.log(error);
                }
            });
        });
        $('#cityId2').change(function(){
            var provinceid = $(this).val();
            $('input[name="methodShipping"]').prop('checked',false);//Bỏ select vận chuyển
            $("#methodShipping").html('');
            //Remove phí ship
            removePriceShip(home_url);
            $('input[name="cusShip[cityname]"]').val($("#cityId2 option:selected").attr('name'));
            if (provinceid=="") {
                $('#districtId2').html('<option value="" selected>Quận/Huyện</option>');
                $('#districtId2').prop('disabled',true);
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
                    $('#districtId2').html(html);
                    loadding('remove');
                    $('#districtId2').prop("disabled", false);
                },
                error:function (error) {
                    //console.log(error);
                }
            });
        });

        
    }
    var chooseDistrict = function(home_url){
        $('#districtId,#districtId2').change(function(){
            $('input[name="cus[districtname]"]').val($("#districtId option:selected").attr('name'));
            var provinceid;
            var districtid;
            if($('#chooseAddShipping').is(':checked')){
                provinceid = $('select[name="cusShip[cityId]"]').val();
                districtid = $('select[name="cusShip[districtId]"]').val();
             }else{
                provinceid = $('select[name="cus[cityId]"]').val();
                districtid = $('select[name="cus[districtId]"]').val();
             }
             $('input[name="methodShipping"]').prop('checked',true);
             getListCarrierService(home_url,provinceid,districtid);
             $("#methodShipping").slideDown();

        });
    }
    var getShippingMethod = function (home_url) {
        //choose shipping method
        $('body').on('click','#chooseMethodShipping',function(){
            if($('#chooseAddShipping').is(':checked')){
                provinceid = $('select[name="cusShip[cityId]"]').val();
                districtid = $('select[name="cusShip[districtId]"]').val();
             }else{
                provinceid = $('select[name="cus[cityId]"]').val();
                districtid = $('select[name="cus[districtId]"]').val();
             }
            
            if($(this).is(':checked')){
               $("#methodShipping").slideDown();
               getListCarrierService(home_url,provinceid,districtid);
             }else{
               $("#methodShipping").slideUp();
               loadding('load');
               //Remove phí ship
                removePriceShip(home_url);
             }
        });
    }
    var getListCarrierService = function(home_url,provinceid,districtid){
        loadding('load');
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
    var removePriceShip = function(home_url){
        //Update lại tiền ship khi không chọn dịch vụ vận chuyển
        $.ajax({
            url: home_url+'/payment-payment-updatePriceShipping.html',
            data:{action:'removeShip'},
            type:'POST',
            dataType:'JSON',
            success:function(res){
                $('.cartReview').load(home_url+'/payment-payment-step2.html .cartReview > *');
                loadding('remove');
            },
            error:function (error) {
                //console.log(error);
            }
        });
    }
    var addAddShipping = function (home_url) {
        //choose shipping method 
         $('#chooseAddShipping').bind('click',function(){
             if($(this).is(':checked')){
                $('#addressShipping').find('input[type="text"]').attr('class','validate[required] input');
                $("#addressShipping").slideDown();
                removePriceShip(home_url);
                $("#methodShipping").html('');
                $('input[name="methodShipping"]').prop('checked',false);
             }else{
                $('#addressShipping').find('input[type="text"]').attr('class','input');
                $('#addressShipping').find('.formError').remove();
                $("#addressShipping").slideUp();
                removePriceShip(home_url);
                $("#methodShipping").html('');
                $('input[name="methodShipping"]').prop('checked',false);
             }
         });
    }

    var addVoice = function () {
        //choose shipping method 
         $('#chooseVoiceShipping').bind('click',function(){
             if($(this).is(':checked')){
                $('#voiceShipping').find('input[type="text"]').attr('class','validate[required] input');
               $("#voiceShipping").slideDown();
             }else{
                $('#voiceShipping').find('input[type="text"]').attr('class','input');
                $('#voiceShipping').find('.formError').remove();
                 $("#voiceShipping").slideUp();
             }
         });
    }
        
    var updatePriceShipping = function(home_url){
        $('body').on('click','#priceShipping tbody tr',function(){
            $('#priceShipping tbody tr').removeClass('tr_selected');
            $('#priceShipping tbody tr input').prop('checked',false);
            $(this).addClass('tr_selected');
            $(this).find('input').prop('checked',true);
            //lấy quận huyện
            var provinceid, districtid;
             if($('#chooseAddShipping').is(':checked')){
                provinceid = $('select[name="cusShip[cityId]"]').val();
                districtid = $('select[name="cusShip[districtId]"]').val();
             }else{
                provinceid = $('select[name="cus[cityId]"]').val();
                districtid = $('select[name="cus[districtId]"]').val();
             }
             //
             var carrierId = $(this).attr('data-carrierId');
             var serviceId = $(this).attr('data-serviceId');

            loadding('load');
            //Tính toán phí ship
            $.ajax({
                url: home_url+'/payment-payment-updatePriceShipping.html',
                data:{serviceId:serviceId,carrierId:carrierId,provinceid:provinceid,districtid:districtid},
                type:'POST',
                dataType:'JSON',
                success:function(res){
                    //Update lại bảng sản phẩm và tổng tiền
                    $('.cartReview').fadeOut("fast").load(home_url+'/payment-payment-step2.html .cartReview > *').fadeIn("slow");
                    loadding('remove');
                },
                error:function (error) {
                    //console.log(error);
                }
            });
        });
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
    function submit(){
        $('button[type="submit"]').on('click',function(){
            loadding('load');
        });
    }



 return {
        //main function to initiate the module
        init: function (home_url) {
            getDistric(home_url);
            chooseDistrict(home_url);
            getShippingMethod(home_url);
            addAddShipping(home_url);
            addVoice();
            updatePriceShipping(home_url);
            submit();
            

            $('.title').bind('click',function(event){
                $('.listBank').removeClass('active');
                $(this).parent().find('.listBank').addClass('active');
            });
            $('.bankItem').bind('click',function(){
                $('#paymentPost').append('');
                $('.bankItem').removeClass('active');
                $('.listBank .notice').html('Vui lòng chọn ngân hàng bạn sẽ thanh toán');
                $(this).addClass('active');
                var bankname = $(this).attr('title');
                var bankId = $(this).attr('data-baokimpmid');
                $('input[name="bankId"]').val(bankId);
                $('input[name="bankName"]').val(bankname);
                $(this).parents('.listBank').find('.notice').html('Bạn đã chọn ngân hàng:<b> '+bankname+'</b>');
                //
                $('.divInfoBanks').slideUp();
                $(this).parents('li').find('.divInfoBanks').slideDown();
                
            });
            
            $('input[name="cus[cityname]"]').val($("#cityId option:selected").attr('name'));
            $('input[name="cus[districtname]"]').val($("#districtId option:selected").attr('name'));
            //
            if($('#chooseAddShipping').is(':checked')){
                $('#addressShipping').css('display','block');
            }
            //check method choice
            var payType = $('input[name="paymentMethod"]').val();
            if (payType != 0 && payType!=7 && payType !==6) {
                $('input[name="bankId"]').addClass('validate[required]');
            }
        }
    };

}();