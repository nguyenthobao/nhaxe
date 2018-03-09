var recruit = function(e) {

	var initComponents = function() {

		$('#recruit_limit').change(function(){
			if(this.value!='0'){
			this.form.submit();
			}
		  
		});
	}

	return {
		//main function to initiate the module
		init : function(e) {
			initComponents();
		}
	};

}(); 

//search form
function q(){
	var q = $('#srch').val();
	if (q=='') {
		alert('Vui lòng nhập từ khóa!');
		return false;
	}
	$('#fsrch').submit();
}
      