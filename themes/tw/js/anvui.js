 var dateToday = new Date();
    var startPoint ='';
    var endPoint ='';
    var date ='';
    $(function() {
       
        $('#datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            minDate: dateToday
        });
        $('.datetimepicker-table').datetimepicker({
            format: 'DD-MM-YYYY',
            minDate: dateToday
        }).on("dp.change", function(e) {
            if(e.oldDate != null){
                // var startPointId = $(this).attr('data-start');
                // var endPointId = $(this).attr('data-end');
                var startPoint = $(this).attr('data-start-name');
                var endPoint = $(this).attr('data-end-name');
                console.log(startPointId);
                console.log(endPointId);
                console.log(e.date.format('DD-MM-YYYY'));
                
                window.location.href = '/tim-ve?startPoint='+startPoint+'&endPoint='+endPoint+'&date='+e.date.format('DD-MM-YYYY');
            }
        }); 


    }); 



        $(document).ready(function() {
  
            $( ".startPoint" ).autocomplete({ 
              source: "http://anvui.vn/point",
              minLength: 1,
              select: function( event, ui ) { 
                startPoint = ui.item.id;
                $('#startPointId').val(startPoint); 
              }
            });
            $( ".endPoint" ).autocomplete({ 
              source: "http://anvui.vn/point",
              minLength: 1,
              select: function( event, ui ) { 
                endPoint = ui.item.id;
                $('#endPointId').val(endPoint); 
              }
            }); 


        })