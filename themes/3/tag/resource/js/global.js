function ajax_global(dataString,urlSend,method,type){
	var res='';
	$.ajax({
		url: $('base').attr('href')+urlSend+$('base').attr('extention'),
		type: method,
		async:false,
		dataType: type,
		data: dataString,
	})
	.success(function(res) {
		result=res;
	})
	.error(function(error) {
		console.log(error);
	});
	return result;
}