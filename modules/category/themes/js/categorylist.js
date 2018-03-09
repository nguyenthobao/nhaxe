var CategoList = function () {

    var checkboxAll = function(){
        $('#checkboxAll').click(function() {
            if ($(this).prop("checked") == true) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", true);
                    $(this).parent().addClass('checked');
                });

                $(".btn-del a").removeClass('disabled');
                $(".copy_cate a").removeClass('disabled');
            } else if ($(this).prop("checked") == false) {
                $('.checkboxes').each(function(index) {
                    $(this).prop("checked", false);
                    $(this).parent().removeClass('checked');
                });
                $(".btn-del a").addClass('disabled');
                $(".copy_cate a").addClass('disabled');
            }
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_cate a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_cate a").addClass('disabled');
            }
        });
        $('.checkboxes').click(function() {
            if ($(this).prop("checked") == false) {
                $('#checkboxAll').prop("checked", false);
                $('#checkboxAll').parent().removeClass('checked');
            }
        });
    }
     var enableDelete = function() {
        $('.checkboxes').click(function(){
            if ($('.checkboxes:checked').length > 0) {
                $(".btn-del a").removeClass('disabled');
                $(".copy_cate a").removeClass('disabled');
            } else {
                $(".btn-del a").addClass('disabled');
                $(".copy_cate a").addClass('disabled');
            }
        
        });
    }
     var copyCate= function(){
       $('.copyCats').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#categorylist tr').find('.delete_multi_category').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn copy những chuyên mục đã chọn ?</li>',
                title: "Copy chuyên mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'category-ajax-lang-'+lang, 
                            type: 'POST',
                            data: {action:'copyCate',key:key},
                            success: function(data){
                               
                                 window.location.reload(true);
                                 //document.write(data);
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
    var searchCategory = function(){
        $("#bnt_search").live('click',function() {          
            $('input[name="action"]').val("searchCategory");
            $('#form_categorylist').submit();
        });
    }
    var fastEdit = function () {
        var lang = $("#categorylist").attr('data-lang');
        $.fn.editable.defaults.mode = 'inline';
         //global settings 
        $.fn.editable.defaults.inputclass = 'form-control';
        $('.catItem').editable({
            url: 'category-ajax-lang-'+lang,
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
    var deleteCategory = function(){
        $('.delete_category').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key = $this.parents('tr').attr('data-key');
           
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá ?</li>',
                title: "Xoá chuyên mục",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'category-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteCategory',key:key},
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

     var deleteMulti = function(){
        $('.delete_category_select').click(function(){
            var lang = $("#categorylist").attr('data-lang');
            var $this = $(this);
            var key= new Array();
            $('#categorylist tr').find('.delete_multi_category').each(function() {
                if($(this).is(':checked')) {
                    key.push($(this).val());
                }
            });
          
            bootbox.dialog({
                message: '<li class="list-group-item list-group-item-warning">Cảnh báo: Bạn chắc chắn xoá những chuyên mục đã chọn ?</li>',
                title: "Xoá chuyên mục đã chọn",
                buttons: {
                  success: {
                    label: "Đồng ý",
                    className: "green",
                    callback: function() {
                        $.ajax({
                            url: 'category-ajax-lang-'+lang, //dev2.webbnc.vn/video-ajax-lang-vi|en
                            type: 'POST',
                            data: {action:'deleteMulti',key:key},
                            success: function(data){
                               // $this.parents('tr').remove();
                                //Chuyển string sang mảng dùng split
                                var data2 = data.split(",");
                               // alert(data2);
                                 $.each(data2, function(k,v){
                                    $('#tr_' + v).remove();
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
    var activeStatusCategory = function(){
        $('.active_status').click(function(e,data){
            var $this = $(this);
            var statusCurren = $this.attr('data-status');
            var key = $this.parents('tr').attr('data-key');
            var lang = $this.parents('tr').attr('data-lang');
            if (statusCurren==1) {var status=0;}else{ var status=1; }
            $.ajax({
                url: 'category-ajax-lang-'+lang,
                type: 'POST',
                data: {action:'activeStatusCategory',key:key,status:status},
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
     var checkCharacterEdit = function () {
        $('.editable-input input').live('keypress',function(){
            var val = $(this).val();
            var length = val.length;
            $('.form-control').attr("maxlength","60");
            if (length < 60 ) {
                var charact = val.split(" ");
                $.each(charact,function(k,v){
                    if (v.length>10) {
                        alert("Một từ của bạn không được nhập vào quá 10 ký tự");
                        $('.editable-input input').val(val.substr(0,10));
                        return false;
                    }
                });
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
           checkboxAll();
           deleteCategory();
           activeStatusCategory();
           fastEdit();
           deleteMulti();
           searchCategory();
           enableDelete();
           checkCharacterEdit();
           copyCate();
           // handle editable elements on hidden event fired
            $('#categorylist .editable').on('hidden', function (e, reason) {
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