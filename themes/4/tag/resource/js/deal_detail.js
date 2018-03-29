var Deal_detail = function () {
    var downTime=function(){
       var time=parseInt($('#exp_time').attr('data-time'));
       if(time!=0){
            var downTime = new Date(time*1000);
            $('#downtime').countdown({until: downTime});
       }
    }

    return {
        init: function () {
            downTime();
        },

    };
}();