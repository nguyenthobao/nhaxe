function ajax_global(dataString, urlSend, method, type) {
    var res, err;
    var result;
    var request = $.ajax({
        url: $('base').attr('data-home') + '/' + urlSend + $('base').attr('data-ext'),
        method: method,
        cache: false,
        async: false,
        dataType: type,
        data: dataString,
    });
    //Request
    request.success(function(res) {
        result = res;
    });
    request.error(function(err) {
        console.log(err);
        return false;
    });
    return result;

}

function numberFormat(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

String.prototype.replaceNXT = function(strTarget, // The substring you want to replace
    strSubString // The string you want to replace in.
) {
    var strText = this;
    var intIndexOfMatch = strText.indexOf(strTarget);
    // Keep looping while an instance of the target string
    // still exists in the string.
    while (intIndexOfMatch != -1) {
        // Relace out the current instance.
        strText = strText.replace(strTarget, strSubString)
        // Get the index of any next matching substring.
        intIndexOfMatch = strText.indexOf(strTarget);
    }
    // Return the updated string with ALL the target strings
    // replaced out with the new substring.
    return (strText);
}

function replaceAll(find, replace, str) {
    return str.replaceNXT(find, replace);
}


var payment = function() {

    var handleAddress = function() {
        $('body').on('change', 'select[name="payment[city]"],select[name="payment[cus_city]"]', function(event) {
            event.preventDefault();
            var idcity = $(this).val();
            // $.each($(this).find('option'), function(k, v) {
            //     $(v).removeAttr('selected');
            // });
            // $(this).find('option[value="' + idcity + '"]').attr('selected', 'selected');
            var dataString = {
                'idcity': idcity,
            };
            var data = ajax_global(dataString, '/payment-gia247-getdistrict', 'POST', 'json');
            if (data.length) {
                var district = '<option value="0">Quận/Huyện</option>';
                $.each(data, function(k, v) {
                    district += '<option value="' + v['districtid'] + '">' + v['name'] + '</option>';
                });
                var checked = $('input[name="payment[check_same]"]').prop('checked');
                if ($(this).attr('name') == 'payment[city]') {
                    var elDistrict = $('select[name="payment[district]"]');
                    elDistrict.html(district);
                    if (checked == true) {
                        $('select[name="payment[cus_district]"]').html(district);
                        $('select[name="payment[cus_city]"] option[value="' + $(this).val() + '"]').attr('selected', 'selected');
                    }
                } else {
                    var elDistrict = $('select[name="payment[cus_district]"]');
                    elDistrict.html(district);
                    if (checked == true) {
                        $('select[name="payment[cus_district]"] option[value="' + $(this).val() + '"]').attr('selected', 'selected');
                    }
                }
                setTimeout(function() {
                    open(elDistrict);
                }, 100);
            }

        });
        $('body').on('change', 'input[name="payment[check_same]"]', function(event) {
            event.preventDefault();
            var checked = $(this).prop('checked');
            if (checked == false) {
                $('.info_buyer_content').slideDown();
                $(this).removeAttr('checked');
            } else {
                $('.info_buyer_content').slideUp();
                $(this).attr('checked', 'checked');;
                handleSameAddress();
            }
        });

        $('body').on('change', 'select[name="payment[district]"]', function(event) {
            event.preventDefault();
            var id = $(this).val();
            var checked = $('input[name="payment[check_same]"]').prop('checked');
            if (checked == true) {
                $('select[name="payment[cus_district]"] option[value="' + id + '"]').attr('selected', 'selected');
            }
            handleShip();


        });

        $('body').on('change', 'select[name="payment[cus_district]"]', function(event) {
            event.preventDefault();
            handleShip();

        });
    }
    var handleSameAddress = function() {
        var el = 'input[name="payment[name]"],input[name="payment[email]"],input[name="payment[phone]"],textarea[name="payment[address]"]';
        $('body').on('keyup blur focusout', el, function(event) {
            event.preventDefault();
            var checked = $('input[name="payment[check_same]"]').prop('checked');
            if (checked == true) {
                var str = $(this).attr('name');
                var re = /payment\[(.*)]/;
                if ((m = re.exec(str)) !== null) {
                    if (m.index === re.lastIndex) {
                        re.lastIndex++;
                    }
                    $('input[name="payment[cus_' + m[1] + ']"]').val($(this).val());
                    $('textarea[name="payment[cus_' + m[1] + ']"]').val($(this).val());
                }
            }
        });
        var elArrs = el.split(',');
        var checked = $('input[name="payment[check_same]"]').prop('checked');
        $.each(elArrs, function(k, v) {
            var tmp_el = $(v);
            var tmp_val = tmp_el.val();
            var tmp_name = tmp_el.attr('name');
            //acb
            if (checked == true) {
                var str = tmp_name;
                var re = /payment\[(.*)]/;
                if ((m = re.exec(str)) !== null) {
                    if (m.index === re.lastIndex) {
                        re.lastIndex++;
                    }
                    $('input[name="payment[cus_' + m[1] + ']"]').val(tmp_val);
                }
            }
        });
        var htmDistrict = $('select[name="payment[district]"]').html();
        $('select[name="payment[cus_district]"]').html(htmDistrict);
        $('select[name="payment[cus_city]"] option[value="' + $('select[name="payment[city]"]').val() + '"]').attr('selected', 'selected');
        $('select[name="payment[cus_district]"] option[value="' + $('select[name="payment[district]"]').val() + '"]').attr('selected', 'selected');
    }
    var handleSubmitOrder = function() {
        $('body').on('click', '#submitOrder', function(event) {
            event.preventDefault();
            //Kiểm tra những thông tin đang bỏ trống
            var allInput = ['input[name="payment[name]"]', 'input[name="payment[cus_name]"]', 'input[name="payment[email]"]', 'input[name="payment[cus_email]"]', 'input[name="payment[phone]"]', 'input[name="payment[cus_phone]"]', 'select[name="payment[city]"]', 'select[name="payment[cus_city]"]', 'select[name="payment[district]"]', 'select[name="payment[cus_district]"]'];
            $('.has-error p').hide();
            $('.has-error').removeClass('has-error');
            var status = true;
            $.each(allInput, function(k, v) {
                var el = $(v);
                var validate = validateForm(el.val(), el.attr('type'));
                if (el.val() == false || el.val() == 0 || validate == false) {
                    var tmp_parent = el.parents('.input-form');
                    tmp_parent.addClass('has-error');
                    tmp_parent.find('p').html('<small><i class="fa fa-exclamation-circle"></i> Vui lòng điền chính xác thông tin này.</small>').addClass('text-danger').show();
                    el.focus();
                    status = false;
                    return false;
                }
            });
            //Lấy toàn bộ input có name = payment
            var dataPay = $('#formOrder').serializeArray();
            var arrs_key = [];
            var arrs_val = [];
            $.each(dataPay, function(k, v) {
                var re = /payment\[([a-z0-9_-]+)\]/i;
                var m;
                if ((m = re.exec(v.name)) !== null) {
                    if (m.index === re.lastIndex) {
                        re.lastIndex++;
                    }
                    if (m[1]) {
                        var tmp_name = m[1];
                        arrs_key.push(tmp_name);
                        var tmp_val = v.value;
                        arrs_val.push(tmp_val);

                    }
                }
            });
            var dataString = {
                key: arrs_key,
                val: arrs_val,
            };
            if (status == true) {
                var data = ajax_global(dataString, '/payment-gia247-Submitorder', 'POST', 'json');
                if (typeof data.type != 'undefined' && data.type == 'pay_online') {
                    $('#modalRedirect').find('.order_code').text(data.order_code);
                    $('#modalRedirect').find('.total_price').text(data.total_price);
                    $('#modalRedirect').find('.receiver_name').text(data.receiver['cus_name']);
                    $('#modalRedirect').find('.receiver_phone').text(data.receiver['cus_phone']);
                    $('#modalRedirect').find('.receiver_email').text(data.receiver['cus_email']);
                    $('#modalRedirect').find('.receiver_address').text(data.receiver['cus_address'] + ', ' + data.receiver['cus_district'] + ', ' + data.receiver['cus_city']);
                    $('#modalRedirect').find('.payNow').attr('href', data.url);
                    $('#modalRedirect').modal({
                        keyboard: false,
                        show: true,
                        backdrop: 'static',
                    });
                } else {
                    window.location.href = data.url;
                }

            }
        });
    }
    var handleChangeQuantity = function() {
        $('body').on('change', 'select[name="quantity"]', function(event) {
            event.preventDefault();
            var quantity = $(this).val();
            var key = $(this).attr('data-key');
            var dataString = {
                'key': key,
                'quantity': quantity,
            };
            var data = ajax_global(dataString, '/product-ajaxCart-changequantity', 'POST', 'json');
            if (data.status == true) {
                $("#reloadProduct").load(document.URL + " #reloadProduct");
                $("#reloadDola").load(document.URL + " #reloadDola");
            }
            handleShip();
        });
    }
    var handleRemoveProduct = function() {
        $('body').on('click', '.delete', function(event) {
            event.preventDefault();
            var key = $(this).attr('data-key');
            var dataString = {
                'key': key,
            };
            var data = ajax_global(dataString, '/product-cart-removeproductcart', 'POST', 'json');
            if (data.status == true) {
                $("#reloadProduct").load(document.URL + " #reloadProduct");
                $("#reloadDola").load(document.URL + " #reloadDola");
            } else {
                window.location.href = $('base').attr('data-home');
            }
            handleShip();
        });
    }
    var handleExportBill = function() {
        $('body').on('click', '#exportBill', function(event) {
            event.preventDefault();
            $('#box_order_bill').slideToggle();
        });
    }

    var handleSelectBank = function() {
        $('body').on('click', '.list_data_bank', function(event) {
            event.preventDefault();
            removeSelectBank();
            var el = $(this);
            $('input[name="payment[bk_item_bank]"]').val(el.attr('data-id'));
            el.addClass('item_bank_selected');
            el.find('i').addClass('icon_select_bank');
        });
        //Phuong thuc thanh toan truc tuyen
        $('body').on('change', 'input[name="payment[paymentonline]"]', function(event) {
            event.preventDefault();
            removeSelectBank();
            var el = $(this);
            el.parents('ul').find('ul').slideUp();
            el.parents('.has-sub').find('ul').slideDown();
        });
    }
    var handlePayMethod = function() {
        $('body').on('change', 'input[name="payment[method]"]', function(event) {
            event.preventDefault();
            var val = $(this).val();
            if (val == 'option2') {
                $('#cssmenu').slideDown();
            } else if (val == 'option1') {
                $('#cssmenu').slideUp();
                $('#cssmenu').find('input[type="radio"]').prop('checked', false);
                $('input[name="payment[bk_item_bank]"]').val(0);
            }
        });
    }
    var handleShip = function() {
        var city = $('select[name="payment[cus_city]"] option:selected').val();
        var district = $('select[name="payment[cus_district]"] option:selected').val();
        if (city != false && district != false) {
            var dataString = {
                'to_city_code': city,
                'to_district_code': district,
            };
            $.ajax({
                url: $('base').attr('data-home') + '/payment-gia247-getpriceship' + $('base').attr('data-ext'),
                type: 'POST',
                dataType: 'json',
                data: dataString,
            }).success(function(ship) {
                if (ship) {
                    var htm = '';
                    if (ship.status == false) {
                        htm += '<div class="NoBusinessSupport">';
                        htm += '<i class="fa fa-exclamation-triangle" style="color:red;"></i> Thông báo.';
                        htm += '<p><small>' + v_ship.message + '</small></p>';
                        htm += ' </div>';
                    } else {
                        $.each(ship.service, function(k, v) {
                            htm += '<div class="ShipOrder">';
                            //Dịch vụ order cung cấp
                                var checked_ks = '';
                                if (v.checked != 0) {
                                    checked_ks = 'checked="checked"';
                                }
                                htm += '<div class="BusinessService">';
                                htm += ' <input ' + checked_ks + ' class="shipFee" name="payment[shipService]" value="' + v['service_id'] + '-' + v['fee'] + '"  data-fee="' + v['fee'] + '" type="radio" id="shipService_'+v['service_id']+'"> <label for="shipService_'+v['service_id']+'">' + v['name'] + '</label>';
                                htm += ' <p><small>Cước phí ' + v['fee_format'] + '</small></p>';
                                htm += '</div>'; //Kết thúc dịch vụ cung cấp
                            htm += '</div>'; //Kết thúc
                        });
                    }
                    $('.ship-content').html(htm);
                    setTimeout(function() {
                        handleShipFee();
                    }, 1000);
                }

            });
        }
    }
    var handleChangeShip = function() {
        $('body').on('change', '.shipFee', function(event) {
            event.preventDefault();
            setTimeout(function() {
                handleShipFee();
            }, 1000);
        });
    }
    var handleShipFee = function() {
        //Đặt lại ông ship
        var total_ship = 0;
        var total_price = 0;
        total_price += parseInt($('#totalPrice').attr('data-price'));
        $('.shipFee').each(function(k, v) {
            var el = $(v);
            if (el.prop('checked')) {
                total_ship += parseInt(el.attr('data-fee'));
            }
        });
        total_price = numberFormat(total_price + total_ship, 0, '.', '.') + ' đ';
        total_ship = numberFormat(total_ship, 0, '.', '.') + ' đ';
        $('#totalPrice').text(total_price);
        $('#totalShipFee').text(total_ship);
    }

    var numberFormat = function(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    var removeSelectBank = function() {
        $.each($('.list_data_bank'), function(k, v) {
            var tmp_el = $(v);
            tmp_el.removeClass('item_bank_selected');
            tmp_el.find('.icon_select_bank').removeClass('icon_select_bank');
        });
    }
    var strpos = function(haystack, needle, offset) {
        var i = (haystack + '').indexOf(needle, (offset || 0));
        return i === -1 ? false : i;
    }
    var validateForm = function(val, type) {
        if (type == 'email') {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(val);
        } else if (type == 'phone') {
            if (isNaN(parseInt(val)) || parseInt(val) == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    var open = function(elem) {
        if (document.createEvent) {
            var e = document.createEvent("MouseEvents");
            e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            elem[0].dispatchEvent(e);
        } else if (element.fireEvent) {
            elem[0].fireEvent("onmousedown");
        }
    }
    return {
        init: function() {
            handleAddress();
            handleSameAddress();
            handleSubmitOrder();
            handleExportBill();
            handleSelectBank();
            handlePayMethod();
            handleChangeQuantity();
            handleRemoveProduct();
            handleChangeShip();
        }
    };
}();
$(function() {
    payment.init();
    $('[data-toggle="tooltip"]').tooltip();
});