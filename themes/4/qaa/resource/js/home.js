var faq = function(e) {

	var initComponents = function(e) {
		$('.onloadcontent a.active').each(function(i) {
            delayedTrigger( $(this), 1000 );
        });
        function delayedTrigger(elem, delay)
        {
        setTimeout( function() { $(elem).trigger('click'); }, delay );
        }

		$(".f-qaList-sotr a").click(function() {
		var sval = $(this).attr("data-type");
		var parent = $(this).parent().parent('.f-qaList-body');
		parent.find('input[name=sort]').val(sval);
		var cate = parent.find('input[name=category]').val();
		loadFAQ(e, parent.find('.f-qaList-body-ul'), sval, 1, cate);
		parent.find(".f-qaList-sotr a").removeClass("active");
		$(this).addClass("active");
		});

		$('.main-list').slimscroll({
           height: 'auto'
      	});
      	$('.category-list').slimscroll({
           height: 'auto'
      	});
      //
		$('.f-qaList-body-ul').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				var sort = $(this).parent().parent().parent('.f-qaList-body').find('input[name=sort]').val();
				var cate = $(this).parent().parent().parent('.f-qaList-body').find('input[name=category]').val();
				loadFAQ(e, $(this), sort, null, cate);
			}
		}); 
	}
	var maxId = function(selector) {
    var min=null, max=null;
    $(selector).each(function() {
        var id = parseInt(this.id, 10);
        if (isNaN(id)) { return; }
        if ((min===null) || (id < min)) { min = id; }
        if ((max===null) || (id > max)) { max = id; }
    });
    return max
	}
	
	var loadFAQ = function(e, element, param, chk, cat) {
    	var n = element.children('li').length;
    	if(!n || chk!=null) n=0;
    	var cate = '';
    	if(cat!=null) cate = cat;
    	
        $.ajax({
            url: e['load_faq_url'],
            type: 'POST',
            data:{num:n, sort:param, category:cate},
            success:function(data) {
            	if(chk){
            	element.html(data);  
            	}else{
                element.append(data); 
                }         
            }
        });
	}
	

	return {
		//main function to initiate the module
		init: function(e){
			initComponents(e);
		}
	};

}(); 

