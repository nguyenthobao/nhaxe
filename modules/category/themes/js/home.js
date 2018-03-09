var VideoList = function () {

    var checkboxAll = function(){
        $('#checkboxAll').click(function(){
            if($(this).prop("checked") == true){
                $('.checkboxes').each(function( index ) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });
            }
            else if($(this).prop("checked") == false){
                $('.checkboxes').each(function( index) {
                   $(this).prop("checked",false); 
                   $(this).parent().removeClass('checked');
                });
            }
        });
    }
    var fastEdit = function () {
        var lang = $("#videolist").attr('data-lang');
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.catItem').editable({
            url: 'video-ajax-lang-'+lang,
            type: 'text',
            name: 'editTitleCategory',
            success: function(data, config) {
                console.log(data);
                console.log(config);
            },
            // error: function(errors) {
            //     console.log(errors);
            // }
        });
    }
    var deleteVideo = function(){
        $('.delete_video').click(function(){
            var lang = $("#videolist").attr('data-lang');
            var $this = $(this);
            var key = $this.parents('tr').attr('data-key');
           
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá ?</li>',
                title: "Xoá Video",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'video-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {actionvd:'deleteVideo',key:key},
                            success: function(data){
                                $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                                $.each(data2,function(k,v){
                                    $('#tr_'+v).remove();//xoá thẻ html theo id (vd id="tr_220") <tr id="tr_220"></tr>
                                });
                            }
                        });
                    }
                  },
                  danger: {
                    label: "Huỷ",
                    className: "red",
                    callback: function() {
                      return;
                    }
                  }
                }
            });
        });
    }
    var activeStatusVideo = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'video-ajax-lang-'+lang,
                type: 'POST',
                data: {actionvd:'activeStatusVideo',key:key,status:status},
                success: function(data){
                    if (statusCurren==1) {
                        $this.removeClass('green-stripe');
                        $this.addClass('red-stripe');
                        $this.text('Đang ẩn');
                        $this.attr('data-status',0);
                    }else{
                        $this.removeClass('red-stripe');
                        $this.addClass('green-stripe');
                        $this.text('Đang hiện');
                        $this.attr('data-status',1);
                    }
                }
            });
        });
    }
    return {
        //main function to initiate the module
        init: function () {
           checkboxAll();
           deleteVideo();
           activeStatusVideo();
           fastEdit();
           // handle editable elements on hidden event fired
            $('#videolist .editable').on('hidden', function (e, reason) {
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable');
                    if ($('#autoopen').is(':checked')) {
                        setTimeout(function () {
                            $next.editable('show');
                        }, 300);
                    } else {
                        $next.focus();
                    }
                }
            });
        }
    };

}();