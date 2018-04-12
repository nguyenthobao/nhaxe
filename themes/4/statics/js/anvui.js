//Các biến global
var depatureDate;
var returnDate;
var routeId;
var routeBackId;
var tripIdOneway; //Trip chuyen di
var tripIdReturn; //Trip chuyen di
var scheduleIdOneway; //Schedule chuyen di
var scheduleIdReturn; //Schedule chuyen ve
var startPoint;
var endPoint;
var isRound;
var seatInfoOneway;
var seatInfoReturn;
var ticketPriceOneway = 0;
var ticketPriceReturn = 0;
var ticketRatioOneway = 0;
var ticketRatioReturn = 0;
var ghenguoilondi = [];
var ghenguoilonve = [];
var ghetreemdi = [];
var ghetreemve = [];
var babyMoney = 0;
var adultMoney = 0;
var babyMoneyReturn = 0;
var adultMoneyReturn = 0;
var totalMoneyOneway = 0;
var totalMoneyReturn = 0;
var totalMoney = 0;
var intimeOneway = 0;
var intimeReturn = 0;
var companyId;
var startDate;
var startDateOneway;
var startDateReturn;

var inPointOneway;
var inPointReturn;
var offPointOneway;
var offPointReturn;

var promotionMoney = 0;
var promotionPercent = 0;
var isPromotion = false;

//Biến check ghế trẻ em đi tăng giảm
var checkBabyOnewayLength = 0;
//Biến check ghế người lớn đi tăng giảm
var checkAdultOnewayLength = 0;

var checkBabyReturnLength = 0;
var checkAdultReturnLength = 0;

var hasScheduleOneway = false;
var hasScheduleReturn = false;

$(document).ready(function () {
    $('#next-step').removeClass('scrollDown');
    $('#depatureDate').val($.format.date(new Date() ,"dd/MM/yyyy"));

    companyId = $("base").attr("id");

    if(companyId == 'TC1OHmbCcxRS') {
        $('#radiochuyenkhoan').show();
    }

    //Lấy dữ liệu từ url
    routeId = getParameterByName('routeId');
    startPoint = getParameterByName('startPoint');
    endPoint = getParameterByName('endPoint');
    depatureDate = getParameterByName('depatureDate');
    returnDate = getParameterByName('returnDate');
    routeBackId = getParameterByName('routeBackId');
    routeName = getParameterByName('routeName');

    if(startPoint != null && endPoint != null && depatureDate != null) {
        isRound = 0;
        $('.start').html(routeName.split("-")[0]);
        $('.end').html(routeName.split("-")[1]);
        getSchedule(startPoint, endPoint, depatureDate, routeId, false);
        $('#trip-oneway').show();
        if(returnDate != '' && routeBackId != '') {
            isRound = 1;
            getSchedule(endPoint, startPoint, returnDate, routeBackId, true);
            $('#trip-round').show();
        }
        $('#booking-form').hide();
        $('#next-step').show();
        $('#back').hide();
    }

    //Chỉ cho phép nhập số
    $('#phoneNumber').on('keypress keyup blur', function () {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    //Lấy ajax thông tin chuyến
    $.ajax({
        type: "POST",
        url: "https://anvui.vn/chuyenAV",
        data: {
            idAV: companyId
        },
        success: function (result) {
            if(result.chuyen.length < 1) {
                alert('Nhà xe hiện chưa có tuyến');
                return;
            }
            $.each(result.chuyen, function (key, item) {
                $('#routeId').append('<option value="' + item.routeId + '" data-routeback="' + item.routeBack + '">' + item.routeName + '</option>');
            });

            //Lấy thông tin điểm đầu cuối tren url, neu khong co thi lay chuyen dau tien
            if(routeId != null){
                $('#routeId').val(routeId).change();
            } else {
                $('#routeId').val(result.chuyen[0].routeId).change();
            }

        }
    });

    //Sự kiện thay đổi route
    $('#routeId').change(function () {
        hasScheduleOneway = false;
        hasScheduleReturn = false;
        routeBackId = $(this).find(':selected').data('routeback');
        getPoint($(this).val())
    });

    $('#depatureDate').datepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: "+0d",
        minDate: 0,
        onSelect: function (dateStr) {
            startPoint = $('#startPoint').val();
            endPoint = $('#endPoint').val();
            routeId = $('#routeId').val();
            getSchedule(startPoint, endPoint, dateStr, routeId, false);
            changeDate(dateStr);
        }
    });

    $('#returnDate').datepicker({
        dateFormat: 'dd/mm/yy',
        defaultDate: "+0d",
        minDate: 0,
        onSelect: function (dateStr) {
            getSchedule(endPoint, startPoint, dateStr, routeBackId, true);
        }
    });

    //thiết lập mặc định
    $('#isRoundTrip').val(0);
    $('#returnDate').prop('disabled', true);

    //chọn khứ hồi
    $('#roundtrip').click(function () {
        $('#isRoundTrip').val(1);
        $('.selectday').removeClass('selected');
        $(this).addClass('selected');
        $('#returnDate').prop('disabled', false);
        changeDate($('#depatureDate').val());
    });

    //chọn một chiều
    $('#oneway').click(function () {
        $('#isRoundTrip').val(0);
        $('.selectday').removeClass('selected');
        $(this).addClass('selected');
        $('#returnDate').val('');
        $('#returnDate').prop('disabled', true);
    });

    // Giữ nút thanh toán đi theo chuột
    $(window).scroll(function () {
        searchScroll();
        paymentScroll();
    });

    //Tìm chuyến
    $('#search-btn').click(function () {
        isRound = $('#isRoundTrip').val();
        depatureDate = $('#depatureDate').val();
        returnDate = $('#returnDate').val();
        routeId = $('#routeId').val();
        startPoint = $('#startPoint').val();
        endPoint = $('#endPoint').val();

        var routeName = $('#routeId').find('option:selected').text();

        $('.start').html(routeName.split("-")[0]);
        $('.end').html(routeName.split("-")[1]);
        $('.startDate').html($('#depatureDate').val());
        $('.startDateReturn').html($('#returnDate').val());
        $('.routeName').html(routeName);
        $('.routeNameReturn').html(routeName.split("-")[1] + " - " + routeName.split("-")[0]);

        if(isRound == 1) {
            if(routeBackId === 'undefined') {
                $('#oneway').click();
                $.alert({
                    title: 'Cảnh báo!',
                    type: 'red',
                    typeAnimated: true,
                    content: 'Chuyến không có khứ hồi',
                });
                return false;
            }
        }


        if (routeId === "") {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Chưa chọn tuyến đường',
            });
            return false;
        }

        if (startPoint === "") {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Chưa chọn điểm đi',
            });
            return false;
        }

        if (endPoint === "") {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Chưa chọn điếm đến',
            });
            return false;
        }

        if (depatureDate === "") {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Chưa chọn ngày đi',
                onClose: function () {
                    $('#depatureDate').datepicker('show');
                }
            });

            return false;
        }
        //có khứ hồi
        if(isRound == 1) {

            if (returnDate === "") {
                $.alert({
                    title: 'Cảnh báo!',
                    type: 'red',
                    typeAnimated: true,
                    content: 'Chưa chọn ngày về',
                    onClose: function () {
                        $('#returnDate').datepicker('show');
                    }
                });
                return false;
            }

            $('.endDate').html($('#returnDate').val());

            $('#trip-round').show();
            $('#total-round').show();
            if(!hasScheduleReturn){
                getSchedule(endPoint, startPoint, returnDate, routeBackId, true);
            }

        }

        $('#trip-oneway').show();
        $('#next-step').show();
        $('#booking-form').hide();

        if(!hasScheduleOneway) {
            getSchedule(startPoint, endPoint, depatureDate, routeId, false);
        }

    });

    //Quay lại chọn tuyến
    $('#back').click(function () {
        $('#trip-oneway').hide();
        $('#next-step').hide();
        $('#booking-form').show();
        $('#trip-round').hide();
        $('#total-round').hide();
    });

    //Chuyển sang chọn ghế
    $('#select-seat').click(function () {

        var isRound = $('#isRoundTrip').val();

        if(seatInfoOneway == undefined) {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Chưa chọn chuyến đi',
            });
            return false;
        }

        if(isRound == 1) {

            if(seatInfoReturn == undefined) {
                $.alert({
                    title: 'Cảnh báo!',
                    type: 'red',
                    typeAnimated: true,
                    content: 'Chưa chọn chuyến về',
                });
                return false;
            }

            $('#select-seat-round').show();
            $('#chooseRound').show();
        } else {
            $('#select-seat-round').hide();
            $('#chooseRound').hide();
        }

        $('#trip-oneway').hide();
        $('#next-step').hide();
        $('#trip-round').hide();

        $('#select-seat-oneway').show();
        $('#back-step2').show();
    });
    
    //Kiểm tra khuyến mại
    $('#checkPromotion').click(function () {
        if($('#promotionCode').val() == '') {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Bạn chưa nhập mã khuyến mại',
            });
            return false;
        }

        if(!isPromotion) {
            var promotionCode = $('#promotionCode').val();
            $(this).prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'https://dobody-anvui.appspot.com/web_promotion/check',
                beforeSend: function(request) {
                    request.setRequestHeader("DOBODY6969", 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw');
                },
                data: {
                    timeZone: 7,
                    promotionCode: promotionCode,
                    companyId: companyId
                },
                success: function (data) {
                    promotionPercent = data.results.result.percent;
                    promotionMoney = data.results.result.price;
                    $('#promotionCode').prop('readonly', true);
                    $('#checkPromotion').prop('disabled', false);

                    $('#promotion').show();
                    if(promotionMoney > 0) {
                        $('#promotionPrice').text(promotionMoney.format()+' VND');
                    } else if(promotionPercent > 0) {
                        $('#promotionPrice').text(promotionPercent*100+' %');
                    }


                    $('#checkPromotion').text('X');
                    $('#checkPromotion').removeClass('btn-info');
                    $('#checkPromotion').addClass('btn-danger');

                    if(totalMoney > 0) {
                        if(promotionMoney > 0) {
                            $('#totalMoney').text((totalMoney - promotionMoney).format()+' VND');
                        } else if (promotionPercent > 0) {
                            $('#totalMoney').text((totalMoney - totalMoney*promotionPercent).format()+' VND');
                        }
                    }
                    isPromotion = true;

                },
                error: function () {
                    $.alert({
                        title: 'Cảnh báo!',
                        type: 'red',
                        typeAnimated: true,
                        content: 'Mã khuyến mại không tồn tại',
                    });
                    $('#checkPromotion').prop('disabled', false);
                }
            });
        } else {
            $('#checkPromotion').text('Kiểm tra');
            $('#checkPromotion').removeClass('btn-danger');
            $('#checkPromotion').addClass('btn-info');
            $('#promotionCode').val('');
            $('#promotion').hide();
            $('#promotionCode').prop('readonly', false);

            promotionPercent = 0;
            promotionMoney = 0;
            if(totalMoney > 0) {
                $('#totalMoney').text(totalMoney.format()+' VND');
            }
            isPromotion = false;
        }

    });

    //Xác nhận đặt vé
    $('#hoanthanhbtn').click(function () {
        var mave;
        var paymentType = $('.paymenttype:checked').val();
        var fullName = $('#fullname').val();
        var phoneNumber = $('#phoneNumber').val();
        var email = $('#email').val();
        var note = $('#note').val();

        var seatOneway = ghenguoilondi.concat(ghetreemdi);

        //CHuyen di
        var totalSeat = ghenguoilondi.length + ghetreemdi.length;
        if(totalSeat < 1) {
            $.alert({
                title: 'Thông báo!',
                type: 'orange',
                typeAnimated: true,
                content: 'Hãy chọn ít nhất 1 ghế đi',
            });
            return false;
        }

        if(ghetreemdi.length > 0 && ghenguoilondi.length <1) {
            $.alert({
                title: 'Thông báo!',
                type: 'orange',
                typeAnimated: true,
                content: 'Phải có ít nhất 1 người lớn đi cùng trẻ em',
            });
            return false;
        }

        if($('#fullname').val() == '') {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Bạn chưa nhập tên',
                onClose: function () {
                    $('#fullname').focus();
                }
            });

            return false;
        }

        if($('#phoneNumber').val() == '') {
            $.alert({
                title: 'Cảnh báo!',
                type: 'red',
                typeAnimated: true,
                content: 'Bạn chưa nhập số điện thoại',
                onClose: function () {
                    $('#phoneNumber').focus();
                }
            });
            $('#phoneNumber').focus();
            return false;
        }

        //THanh toan ve 1 chieu
        if(isRound == 0){

            if(promotionMoney > 0) {
                totalMoneyAfter = totalMoney - promotionMoney;
            } else if(promotionPercent > 0) {
                totalMoneyAfter = totalMoney - totalMoney*promotionPercent;
            } else {
                totalMoneyAfter = totalMoney;
            }

            $.ajax({
                type: 'POST',
                url: 'http://demo.nhaxe.vn/dat-ve?sub=order',
                data: {
                    'listSeatId': JSON.stringify(seatOneway),
                    'fullName': fullName,
                    'phoneNumber': phoneNumber,
                    'email': email,
                    'getInPointId': inPointOneway,
                    'startDate': startDateOneway,
                    'getOffPointId': offPointOneway,
                    'scheduleId': scheduleIdOneway,
                    'getInTimePlan': intimeOneway,
                    'originalTicketPrice': totalMoney,
                    'paymentTicketPrice': totalMoneyAfter,
                    'agencyPrice': totalMoneyAfter,
                    'paymentType': paymentType,
                    'paidMoney': 0,
                    'tripId': tripIdOneway,
                    'numberOfAdults': ghenguoilondi.length,
                    'numberOfChildren': ghetreemdi.length,
                    'promotionId': $('#promotionCode').val(),
                    'note' : note
                },
                success: function (data) {
                    if(data.code != 200) {
                        $.alert({
                            title: 'Thông báo!',
                            type: 'red',
                            typeAnimated: true,
                            content: 'Đã có lỗi xảy ra, vui lòng đặt lại!',
                        });
                    } else {
                        //thanh toan truc tuyen
                        if(paymentType == 1) {
                            var url = 'https://dobody-anvui.appspot.com/payment/dopay?vpc_OrderInfo=' + data.results.ticketId + '&vpc_Amount=' + totalMoneyAfter * 100 + '&phoneNumber=' + phoneNumber + "&packageName=web";
                            $.dialog({
                                title: 'Thông báo!',
                                content: 'Hệ thống đang chuyển sang cổng thanh toán, vui lòng đợi trong giây lát',
                                onClose: function (e) {
                                    e.preventDefault();
                                }
                            });
                            setTimeout(function () {
                                window.location.href = url;
                            }, 3000);
                        } else if(paymentType == 6) {
                            $.alert({
                                title: 'Thông báo!',
                                type: 'green',
                                typeAnimated: true,
                                content: 'Đã đặt vé thành công!',
                                onClose: function (e) {
                                    $('#phone').html(phoneNumber);
                                    $('#ticketId').html(data.results.ticketId);
                                    $('#chuyenkhoan').modal('show');
                                    $('#hoanthanhbtn').hide();
                                    $('#btnchuyenkhoan').show();
                                }
                            });
                        } else {
                            $.alert({
                                title: 'Thông báo!',
                                content: 'Bạn đã đặt vé thành công! Vui lòng đến quầy thanh toán và nhận vé',
                                onClose: function () {
                                    window.location.href = '/dat-ve';
                                }
                            });
                        }
                    }
                }
            });
        }
        else //Thanh toan ve khu hoi
        {
            var seatReturn = ghenguoilonve.concat(ghetreemve);
            var totalSeatReturn = ghenguoilonve.length + ghetreemve.length;
            if(totalSeatReturn < 1) {
                $.alert({
                    title: 'Thông báo!',
                    type: 'orange',
                    typeAnimated: true,
                    content: 'Hãy chọn ít nhất 1 ghế về',
                });
                return false;
            }

            if(ghetreemve.length > 0 && ghenguoilonve.length <1) {
                $.alert({
                    title: 'Thông báo!',
                    type: 'orange',
                    typeAnimated: true,
                    content: 'Phải có ít nhất 1 người lớn đi cùng trẻ em',
                });
                return false;
            }

            if(promotionMoney > 0) {
                totalMoneyOneAfter = totalMoneyOneway - promotionMoney;
                totalMoneyReturnAfter = totalMoneyReturn - promotionMoney;
            } else if(promotionPercent > 0) {
                totalMoneyOneAfter = totalMoneyOneway - totalMoneyOneway*promotionPercent;
                totalMoneyReturnAfter = totalMoneyReturn - totalMoneyReturn*promotionPercent;
            } else {
                totalMoneyOneAfter = totalMoneyOneway;
                totalMoneyReturnAfter = totalMoneyReturn;
            }
            var paymentCode = generatePaymentCode();

            $.ajax({
                type: 'POST',
                url: 'http://demo.nhaxe.vn/dat-ve?sub=order',
                data: {
                    'listSeatId': JSON.stringify(seatOneway),
                    'fullName': fullName,
                    'phoneNumber': phoneNumber,
                    'email': email,
                    'getInPointId': inPointOneway,
                    'startDate': startDateOneway,
                    'getOffPointId': offPointOneway,
                    'scheduleId': scheduleIdOneway,
                    'getInTimePlan': intimeOneway,
                    'originalTicketPrice': totalMoneyOneway,
                    'paymentTicketPrice': totalMoneyOneAfter,
                    'agencyPrice': totalMoneyOneAfter,
                    'paymentType': paymentType,
                    'paidMoney': 0,
                    'tripId': tripIdOneway,
                    'numberOfAdults': ghenguoilondi.length,
                    'numberOfChildren': ghetreemdi.length,
                    'promotionId': $('#promotionCode').val(),
                    'note' : note,
                    'paymentCode': paymentCode
                },
                success: function (data) {
                    if(data.code != 200) {
                        $.alert({
                            title: 'Thông báo!',
                            type: 'red',
                            typeAnimated: true,
                            content: 'Đã có lỗi xảy ra, vui lòng đặt lại!',
                        });
                    } else {
                        mave = data.results.ticketId;

                        $.ajax({
                            type: 'POST',
                            url: 'http://demo.nhaxe.vn/dat-ve?sub=order',
                            data: {
                                'listSeatId': JSON.stringify(seatReturn),
                                'fullName': fullName,
                                'phoneNumber': phoneNumber,
                                'email': email,
                                'getInPointId': inPointReturn,
                                'startDate': startDateReturn,
                                'getOffPointId': offPointReturn,
                                'scheduleId': scheduleIdReturn,
                                'getInTimePlan': intimeReturn,
                                'originalTicketPrice': totalMoneyReturn,
                                'paymentTicketPrice': totalMoneyReturnAfter,
                                'agencyPrice': totalMoneyReturnAfter,
                                'paymentType': paymentType,
                                'paidMoney': 0,
                                'tripId': tripIdReturn,
                                'promotionId': $('#promotionCode').val(),
                                'note' : note,
                                'paymentCode': paymentCode,
                                'numberOfAdults': ghenguoilonve.length,
                                'numberOfChildren': ghetreemve.length
                            },
                            success: function (data) {
                                if(data.code != 200) {
                                    $.alert({
                                        title: 'Thông báo!',
                                        type: 'red',
                                        typeAnimated: true,
                                        content: 'Đã có lỗi xảy ra, vui lòng đặt lại!'
                                    });
                                } else {
                                    mave = mave + "-" + data.results.ticketId;
                                    if(paymentType == 1) {
                                        totalMoney = totalMoneyOneAfter + totalMoneyReturnAfter;
                                        var url = 'https://dobody-anvui.appspot.com/payment/dopay?vpc_OrderInfo=' + mave + '&vpc_Amount=' + totalMoney * 100 + '&phoneNumber=' + phoneNumber + "&packageName=web&paymentCode=" + paymentCode;
                                        $.dialog({
                                            title: 'Thông báo!',
                                            content: 'Hệ thống đang chuyển sang cổng thanh toán, vui lòng đợi trong giây lát',
                                            onClose: function (e) {
                                                e.preventDefault();
                                            }
                                        });
                                        setTimeout(function () {
                                            window.location.href = url;
                                        }, 3000);
                                    } else {
                                        $.alert({
                                            title: 'Thông báo!',
                                            content: 'Bạn đã đặt vé thành công! Vui lòng đến quầy thanh toán và nhận vé',
                                            onClose: function () {
                                                window.location.href = '/dat-ve';
                                            }
                                        });
                                    }

                                }
                            }
                        });

                    }
                }
            });
        }


    });
});

//Lấy ajax điểm đầu điểm cuối
function getPoint(routeId) {
    $('#startPoint').html('<option value="">Điểm đi</option>');
    $('#endPoint').html('<option value="">Điểm đến</option>');

    $.ajax({
        type: "POST",
        url: "https://anvui.vn/pointNX",
        data: {
            routeId: routeId
        },
        success: function (result) {

            // routeBackId = result.routeBack;

            //lấy thông tin điểm đầu
            $.each(result.a1, function (key, item) {
                $('#startPoint').append('<option value="' + item.pointId + '">' + item.pointName + '</option>');
            });
            $('#startPoint').val(result.a1[0].pointId).change();

            //lấy thông tin điểm cuối
            $.each(result.a2, function (key, item) {
                $('#endPoint').append('<option value="' + item.pointId + '">' + item.pointName + '</option>');
            });
            $('#endPoint').val(result.a2[0].pointId).change();
        }
    });
}

function generatePaymentCode() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15) + Date.now();
}

//Fixed nut thanh toan
function searchScroll() {
    var heightScroll = $(document).height() - $(window).height() - 430;

    var scrollTop = jQuery(window).scrollTop();
    if (scrollTop >= heightScroll) {
        $('#next-step').removeClass('scrollDown');
    }
    else {
        $('#next-step').addClass('scrollDown');
    }
}

//Fix thanh toan di theo scroll
function paymentScroll() {
    var heightScroll = $(document).height() - $(window).height() - 430;

    var scrollTop = jQuery(window).scrollTop();
    if(isRound == 0) {
        if(scrollTop > 170 && scrollTop <= 666) {
            $('.payment-info').removeAttr( 'style' );
            $('.payment-info').addClass('scrollInfo');
            $('.payment-info').css('top',  '10px');
        } else if(scrollTop > 666) {
            $('.payment-info').removeAttr( 'style' );
            $('.payment-info').css('bottom',  (scrollTop - 600) +'px');
        } else {
            $('.payment-info').removeClass('scrollInfo');
            $('.payment-info').removeAttr( 'style' );
        }
    }

    console.log('heightScroll', heightScroll);
    console.log('scrollTop', scrollTop);
}


//Hàm chọn trip và lấy thông tin trip chieu di
function selectTripOneWay(trip) {
    
    $('#list-oneway>tr').removeClass('trip-active');
    $(trip).addClass('trip-active');

    tripIdOneway = $(trip).data('trip');
    scheduleIdOneway = $(trip).data('schedule');
    intimeOneway = $(trip).data('intime');
    inPointOneway = $(trip).data('getinpoint');
    offPointOneway = $(trip).data('getoffpoint');
    ticketPriceOneway = $(trip).data('price');
    ticketRatioOneway = $(trip).data('ratio');
    startDateOneway = $(trip).data('startdate');
    $('.intime').html(getFormattedDate(intimeOneway, 'time'));

    //chọn trip
    $.getJSON("http://demo.nhaxe.vn/dat-ve?tripId=" + tripIdOneway + '&scheduleId=' + scheduleIdOneway, function (data) {

        var html = '';
        //Theo số tầng
        for (var floor = 1; floor < data.seatMap.numberOfFloors + 1; floor++) {
            if(floor == 1){
                html += '<div class="col-md-6 col-sm-12 col-xs-12 tachtang">';
            } else {
                html += '<div class="col-md-6 col-sm-12 col-xs-12">';
            }

            html += '<div class="col-md-12 col-sm-12 col-xs-12 text-center"><strong>Tầng ' + floor + '</strong></div>';

            //Theo hàng
            for (var row = 1; row < data.seatMap.numberOfRows + 1; row++) {
                //Theo cột
                for (var column = 1; column < data.seatMap.numberOfColumns + 1; column++) {
                    coghe = false;
                    iddd = '';
                    seatInfoOneway = data.seatMap.seatList;// lay du lieu seatMap
                    $.each(data.seatMap.seatList, function (index, val) {
                        var id = val['seatId'];
                        var id1 = id.replace(',', '_');

                        var ticketStatus = 1;

                        if(val['listTicketId'].length > 0) {
                            var lastTicketId =val['listTicketId'][val['listTicketCode'].length - 1];
                        }

                        if(typeof lastTicketId !== 'undefined' && typeof val['ticketInfo'] !== 'undefined') {
                            ticketStatus = val['ticketInfo'][lastTicketId]['ticketStatus'];
                        } else {
                            ticketStatus = val['seatStatus'];
                        }

                        /*console.log(val['seatId'],ticketStatus);
                        console.log(val['seatId'],val['overTime']);
                        console.log(val['seatId'],((ticketStatus == 2 && (val['overTime'] > Date.now() || val['overTime'] == 0)) || ticketStatus == 7));*/

                        iddd = floor + ' ' + row + ' ' + column;
                        if(val['floor'] != floor || val['row'] != row || val['column'] != column) {
                            // coghe = false;
                        } else {
                            coghe = true;
                            //Type = 2 là tài
                            if (val['seatType'] == 2) {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe driver"></div></div>';
                            } else if(val['seatType'] == 1 || val['seatType'] == 5 || val['seatType'] == 6) { // Lần lượt là cửa cửa, Wc, phụ
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe"></div></div>';
                            } else if((ticketStatus == 2 && (val['overTime'] > Date.now() || val['overTime'] == 0)) || ticketStatus == 7) {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe ghedaban"></div></div>';
                            } else {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '">' +
                                    '<div class="chonghe ghetrong" id="chonghe_' + id1 + '" onclick="chonghe(\'' + id + '\')" data-over="' + val['overTime'] + '">' +
                                    '</div></div>';
                            }
                        }
                    });
                    if (!coghe) {
                        html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe"></div></div>';
                    }
                }
            }

            html += '</div>';
        }
        $('#seatMapOneWay').html(html);

    });

    //event double click
    $(trip).dblclick(function () {
        $('#select-seat').click();
    });
}


//Hàm chọn trip và lấy thông tin trip chieu ve
function selectTripRoundWay(trip) {
    $('#list-roundway>tr').removeClass('trip-active');
    $(trip).addClass('trip-active');

    tripIdReturn = $(trip).data('trip');
    scheduleIdReturn = $(trip).data('schedule');
    ticketPriceReturn = $(trip).data('price');
    ticketRatioReturn = $(trip).data('ratio');
    intimeReturn = $(trip).data('intime');
    inPointReturn = $(trip).data('getinpoint');
    offPointReturn = $(trip).data('getoffpoint');
    startDateReturn = $(trip).data('startdate');
    $('.intimeReturn').html(getFormattedDate(intimeReturn, 'time'));

    //chon trip
    $.getJSON("http://demo.nhaxe.vn/dat-ve?tripId=" + tripIdReturn + '&scheduleId=' + scheduleIdReturn, function (data) {

        var html = '';
        //Theo số tầng
        for (var floor = 1; floor < data.seatMap.numberOfFloors + 1; floor++) {
            if(floor == 1){
                html += '<div class="col-md-6 col-sm-12 col-xs-12 tachtang">';
            } else {
                html += '<div class="col-md-6 col-sm-12 col-xs-12">';
            }

            html += '<div class="col-md-12 col-sm-12 col-xs-12 text-center"><strong>Tầng ' + floor + '</strong></div>';

            //Theo hàng
            for (var row = 1; row < data.seatMap.numberOfRows + 1; row++) {
                //Theo cột
                for (var column = 1; column < data.seatMap.numberOfColumns + 1; column++) {
                    coghe = false;
                    iddd = '';

                    seatInfoReturn = data.seatMap.seatList;// lay du lieu seatMap
                    $.each(data.seatMap.seatList, function (index, val) {
                        var id = val['seatId'];
                        var id1 = id.replace(',', '_');

                        var ticketStatus = 1;

                        if(val['listTicketId'].length > 0) {
                            var lastTicketId =val['listTicketId'][val['listTicketCode'].length - 1];
                        }

                        if(typeof lastTicketId !== 'undefined' && typeof val['ticketInfo'] !== 'undefined') {
                            ticketStatus = val['ticketInfo'][lastTicketId]['ticketStatus'];
                        } else {
                            ticketStatus = val['seatStatus'];
                        }

                        iddd = floor + ' ' + row + ' ' + column;
                        if(val['floor'] != floor || val['row'] != row || val['column'] != column) {
                            // coghe = false;
                        } else {
                            coghe = true;
                            //Type = 2 là tài
                            if (val['seatType'] == 2) {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe driver"></div></div>';
                            } else if(val['seatType'] == 1 || val['seatType'] == 5 || val['seatType'] == 6) { // Lần lượt là cửa cửa, Wc, phụ
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe"></div></div>';
                            } else if((ticketStatus == 2 && (val['overTime'] > Date.now() || val['overTime'] == 0)) || ticketStatus == 7) {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe ghedaban"></div></div>';
                            } else {
                                html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '">' +
                                    '<div class="chonghe ghetrong" id="chongheve_' + id1 + '" onclick="chongheve(\'' + id + '\')" data-over="' + val['overTime'] + '">' +
                                    '</div></div>';
                            }
                        }
                    });
                    if (!coghe) {
                        html += '<div class="col-md-2 col-sm-2 col-xs-2 ghe-' + data.seatMap.numberOfColumns + '"><div class="chonghe"></div></div>';
                    }
                }
            }

            html += '</div>';
        }
        $('#seatMapRound').html(html);

    });

    //event double click
    $(trip).dblclick(function () {
        $('#select-seat').click();
    });
}

function chonghe(seat) {
    id = seat.replace(',', '_');
    var isBaby = false;
    seatVal = $.grep(seatInfoOneway,function(val, key){
        return val.seatId == seat;
    })[0];

    //Neu ghe trong thi chuyen sang ghe da chon
    if($('#chonghe_' + id).hasClass('ghetrong')){
        $('#chonghe_' + id).removeClass('ghetrong');
        $('#chonghe_' + id).addClass('ghedachon');
        ghenguoilondi.push(id);
    } else

    //Neu la ghe da chon thi chuyen sang ghe tre em
    if($('#chonghe_' + id).hasClass('ghedachon')) {
        $('#chonghe_' + id).removeClass('ghedachon');
        $('#chonghe_' + id).addClass('ghetreem');
        removeSeatInList(seat, ghenguoilondi);
        ghetreemdi.push(id);
        isBaby = true;
    } else
    //Neu la ghe tre em thi xoa ghe, thanh ghe trong
    if($('#chonghe_' + id).hasClass('ghetreem')) {
        $('#chonghe_' + id).removeClass('ghetreem');
        $('#chonghe_' + id).addClass('ghetrong');
        removeSeatInList(seat, ghetreemdi);
    }

    xacnhan(seatVal, isBaby, false);
}

function chongheve(seat) {
    id = seat.replace(',', '_');
    var isBaby = false;
    seatVal = $.grep(seatInfoReturn,function(val, key){
        return val.seatId == seat;
    })[0];

    //Neu ghe trong thi chuyen sang ghe da chon
    if($('#chongheve_' + id).hasClass('ghetrong')){
        $('#chongheve_' + id).removeClass('ghetrong');
        $('#chongheve_' + id).addClass('ghedachon');
        ghenguoilonve.push(id);
    } else

    //Neu la ghe da chon thi chuyen sang ghe tre em
    if($('#chongheve_' + id).hasClass('ghedachon')) {
        $('#chongheve_' + id).removeClass('ghedachon');
        $('#chongheve_' + id).addClass('ghetreem');
        removeSeatInList(seat, ghenguoilonve);
        ghetreemve.push(id);
        isBaby = true;
    } else
    //Neu la ghe tre em thi xoa ghe, thanh ghe trong
    if($('#chongheve_' + id).hasClass('ghetreem')) {
        $('#chongheve_' + id).removeClass('ghetreem');
        $('#chongheve_' + id).addClass('ghetrong');
        removeSeatInList(seat, ghetreemve);
    }

    xacnhan(seatVal, isBaby, true);
}

function removeSeatInList(item, array) {
    var index = array.indexOf(item);
    if (index > -1) {
        array.splice(index, 1);
    }
}

//Lay thong tin ghe da dat
function xacnhan(seat, isBaby, isBack) {

    //Đoạn làm chiều đi
    if(!isBack) {
        var seatListOneway = ghenguoilondi.concat(ghetreemdi);

        $('#ghedi').html(seatListOneway.toString());

        //Đoạn code ngáo, lúc tỉnh sẽ sửa, vẫn chạy ngon
        if(isBaby) {
            if(ghetreemdi.length > checkBabyOnewayLength) {
                adultMoney -= ticketPriceOneway + seat.extraPrice;
                babyMoney += ticketPriceOneway * ticketRatioOneway + seat.extraPrice;
            } else {
                babyMoney -= ticketPriceOneway * ticketRatioOneway + seat.extraPrice;
                adultMoney += ticketPriceOneway + seat.extraPrice;
            }

        } else {
            if(ghenguoilondi.length > checkAdultOnewayLength) {
                adultMoney += ticketPriceOneway + seat.extraPrice;
            } else {
                if(checkBabyOnewayLength > 0) {
                    babyMoney -= ticketPriceOneway * ticketRatioOneway + seat.extraPrice;
                } else {
                    adultMoney -= ticketPriceOneway + seat.extraPrice;
                }
            }
        }

        checkBabyOnewayLength = ghetreemdi.length;
        checkAdultOnewayLength = ghenguoilondi.length;

        totalMoneyOneway = babyMoney + adultMoney;

        $('#babyMoneyOneWay').text(babyMoney.format()+' VND');
        $('#adultMoneyOneway').text(adultMoney.format()+' VND');
        $('#totalMoneyOneway').text(totalMoneyOneway.format()+' VND');
    } else {
        //Đoạn làm chiều về
        var seatListReturn = ghenguoilonve.concat(ghetreemve);
        $('#gheve').html(seatListReturn.toString());

        //Đoạn code ngáo, lúc tỉnh sẽ sửa, vẫn chạy ngon
        if(isBaby) {
            if(ghetreemve.length > checkBabyReturnLength) {
                adultMoneyReturn -= ticketPriceReturn + seat.extraPrice;
                babyMoneyReturn += ticketPriceReturn * ticketRatioReturn + seat.extraPrice;
            } else {
                babyMoneyReturn -= ticketPriceReturn * ticketRatioReturn + seat.extraPrice;
                adultMoneyReturn += ticketPriceReturn + seat.extraPrice;
            }

        } else {
            if(ghenguoilonve.length > checkAdultReturnLength) {
                adultMoneyReturn += ticketPriceReturn + seat.extraPrice;
            } else {
                if(checkBabyReturnLength > 0) {
                    babyMoneyReturn -= ticketPriceReturn * ticketRatioReturn + seat.extraPrice;
                } else {
                    adultMoneyReturn -= ticketPriceReturn + seat.extraPrice;
                }
            }
        }

        checkBabyReturnLength = ghetreemve.length;
        checkAdultReturnLength = ghenguoilonve.length;

        totalMoneyReturn = babyMoneyReturn + adultMoneyReturn;

        $('#babyMoneyReturn').text(babyMoneyReturn.format()+' VND');
        $('#adultMoneyReturn').text(adultMoneyReturn.format()+' VND');
        $('#totalMoneyReturn').text(totalMoneyReturn.format()+' VND');
    }

    //Tổng tiền 2 chiều
    totalMoney = totalMoneyOneway + totalMoneyReturn;
    if(promotionMoney > 0) {
        $('#totalMoney').text((totalMoney - promotionMoney).format()+' VND');
    } else if(promotionPercent > 0) {
        $('#totalMoney').text((totalMoney - totalMoney*promotionPercent).format()+' VND');
    } else {
        $('#totalMoney').text(totalMoney.format()+' VND');
    }
}


//Đổi ngày về theo ngày đi
function changeDate(dateStr) {
    if(dateStr === '') {
        return;
    }
    var date_Str = '';
    for (var i = 0; i < 10; i++) {

        if (i == 1 || i == 0) {
            date_Str += dateStr.charAt(i + 3);
        } else if (i == 3 || i == 4) {
            date_Str += dateStr.charAt(i - 3);
        }
        else date_Str += dateStr.charAt(i);
    }
    isRound = $('#isRoundTrip').val();
    if(isRound == 1) {
        $('#returnDate').datepicker("option", {
            minDate: new Date(date_Str)
        });
        getSchedule(endPoint, startPoint, dateStr, routeBackId, true);
        $('#returnDate').val(dateStr);
    }
}

//Lấy danh sách các giờ chạy
function getSchedule(startPoint, endPoint, date, routeId, isBack) {
    var dateAr = date.split('/');
    var newDate = dateAr[0] + '-' + dateAr[1] + '-' + dateAr[2];
    $.ajax({
        type: "POST",
        url: "https://anvui.vn/listSchedule",
        data: {
            startPoint: startPoint,
            endPoint: endPoint,
            timeStart: newDate,
            routeId: routeId
        },
        success: function (result) {
            if(!isBack) {
                $('#list-oneway').html('');
            } else {
                // $('#list-oneway').html('');
                $('#list-roundway').html('');
            }


            $.each(result, function (key, item) {
                if(isBack) {
                    var schedule = '<tr onclick="selectTripRoundWay(this)" ' +
                        'data-ratio="' + item.childrenTicketRatio + '" ' +
                        'data-getinpoint="' + item.getInPointId + '"' +
                        'data-getoffpoint="' + item.getOffPointId + '"' +
                        'data-startdate="' + item.startDate + '" ' +
                        'data-intime="' + item.getInTime + '" ' +
                        'data-trip="' + item.tripId + '" ' +
                        'data-schedule="' + item.scheduleId + '" ' +
                        'data-price="' + item.ticketPrice + '">';
                } else {
                    var schedule = '<tr onclick="selectTripOneWay(this)" ' +
                        'data-ratio="' + item.childrenTicketRatio + '" ' +
                        'data-getinpoint="' + item.getInPointId + '"' +
                        'data-getoffpoint="' + item.getOffPointId + '"' +
                        'data-startdate="' + item.startDate + '" ' +
                        'data-intime="' + item.getInTime + '" ' +
                        'data-trip="' + item.tripId + '" ' +
                        'data-schedule="' + item.scheduleId + '" ' +
                        'data-price="' + item.ticketPrice + '">';
                }
                schedule += '<td>' + item.routeName + '</td>';
                schedule += '<td><strong>'+ item.startTime +'</strong></td>';
                schedule += '<td><strong>'+ getFormattedDate(item.getOffTime) +'</strong></td>';
                schedule += '<td><strong>'+ item.totalEmptySeat +'</strong></td>';
                schedule += '<td class="table-price"><strong>'+ item.ticketPrice1 +' VND</strong></td>';
                schedule += '</tr>';
                if(isBack) {
                    $('#list-roundway').append(schedule);
                    hasScheduleReturn = true;
                } else {
                    $('#list-oneway').append(schedule);
                    hasScheduleReturn = false;
                }
            });
        }
    });
}

//Định dạng tiền
Number.prototype.format = function (e, t) {
    var n = "\\d(?=(\\d{" + (t || 3) + "})+" + (e > 0 ? "\\." : "$") + ")";
    return this.toFixed(Math.max(0, ~~e)).replace(new RegExp(n, "g"), "$&,")
};

function getFormattedDate(unix_timestamp, methor) {
    var date = new Date(unix_timestamp);
    str = '';
    if (methor === 'time') {
        str = $.format.date(date.getTime(), 'HH:mm')
    } else if(methor === 'date') {
        str = $.format.date(date.getTime(), 'dd/MM/yyyy')
    } else {
        str = $.format.date(date.getTime(), 'HH:mm, dd/MM/yyyy')
    }

    return str;
}

//Lay param tren url
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}