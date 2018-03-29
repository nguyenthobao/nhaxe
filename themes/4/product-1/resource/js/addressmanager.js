var Address = function(){
	var deleteInfo = function(){
		$('.delete-info').click(function(){
			var key = $(this).parents('tr').attr('key');
			var stt = $(this).parents('tr').find('td.stt').text();

			if(confirm("Bạn có chắc chắn muốn xóa địa chỉ này ?")){
				$(this).parents('tr').nextAll().each(function(){
					$(this).find('td.stt').text(stt);
					stt = parseInt(stt) + 1;
				});
				$(this).parents('tr').remove();
				var url_ajax = $('body').data('home_url')+'/product-userManager-userAddressManager'+$('body').data('extension');
				$.ajax({
					url: url_ajax, 
					type: 'POST',
					data: {action:'delete',key:key},
					success: function(data){
					}
				});
			}
			else
				return false;

		})
	}
	
	return {
		init: function () {
			deleteInfo();
		}
	};

}();