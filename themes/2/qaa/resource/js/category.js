var faq = function(e) {

	var initComponents = function(e) {
		$(".f-qaList-sotr a").click(function() {
		var sval = $(this).attr("data-type");
		var parent = $(this).parent().parent('.f-qaList-body');
		parent.find('input[name=sort]').val(sval);
		var cate = parent.find('input[name=category]').val();
		loadFAQ(e, parent.find('.f-qaList-body-ul'), sval, 1, cate);
		parent.find(".f-qaList-sotr a").removeClass("active");
		$(this).addClass("active");
		});
      //
       $(window).scroll(function() {
		    if($(window).scrollTop() == $(document).height() - $(window).height()) {
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
            data:{num:n, sort:param, category:cate, q: e['search']},
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

