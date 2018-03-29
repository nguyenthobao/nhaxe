var base_url = $('base').attr('href');
var base_ext = $('base').attr('extention');
var shipfee = function () {
    var handleProvince = function() {
       $('body').on('change', 'select[name="fee_province"]', function(event) {
            event.preventDefault();
            var sl = $('select[name="fee_province"] option:selected');
            var val = sl.val();
            if (val) {
                //Ajax get info pages
                var dataString = {
                    'id_province': val
                };
                var urlSend = base_url + '/product-ajaxShip-getDistrict' + base_ext;
                $.ajax({
                    url: urlSend,
                    type: 'POST',
                    dataType: 'json',
                    data: dataString,
                })
                    .success(function(res) {
                        var htm = '<option value="none">Chọn quận/huyện</option>';
                        $.each(res, function(k, v) {
                            htm += '<option value="' + v.districtid + '">' + v.type + ' ' + v.name + '</option>';
                        });
                        $('select[name="fee_district"]').html(htm);
                        handleSetValInfo('remove');
                    });
            } else {
                handleSetValInfo('remove');
            }
        });

    };
    
    var handleSelectDistrict = function() {
        $('body').on('change', 'select[name="fee_district"]', function(event) {
            event.preventDefault();
            var district = $(this).val();
            var province = $('select[name="fee_province"] option:selected').val();
            var dataString = {
                'id_province': province,
                'id_district': district
            };
            var urlSend = base_url + '/product-ajaxShip-ajaxGetFee' + base_ext;
            $.ajax({
                url: urlSend,
                type: 'POST',
                dataType: 'json',
                data: dataString,
            })
                .success(function(res) {
                    console.log(res);
                    if (res.status === true) {
                        $('.ship_fee').slideDown();
                        $('#span_ship_fee').text(res.fee);
                        if(res.note!='' && res.note != undefined){
                            $('#span_ship_note').text(res.note);
                            $('.ship_note').slideDown();
                        }else{
                            $('.ship_note').slideUp();
                        }
                    }
                });
        });
    };
    
    var handleSetValInfo = function(data) {
        if (data == 'remove') {
            $('input[name="fee"]').val('');
            $('textarea[name="fee_note"]').val('');
            // $('select[name="fee_district"]').html('');
        }
    };
    
    return {
        init: function () {
           handleProvince();
           handleSelectDistrict();
        }
    };
}();

shipfee.init();