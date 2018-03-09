var album = function(e) {

	var initComponents = function() {
		$("img.albumload").bncload({
         effect : "fadeIn"
     });
		// Jcallros
   		if($('#galleria').length > 0){
   	  		 Galleria.loadTheme(jsurl+'/resources/plugins/galleria/themes/classic/galleria.classic.min.js');
			 Galleria.run('#galleria', {
			 autoplay: 3000, // will move forward every 7 seconds
			 fullscreenDoubleTap:true
			});	
		}
		//
		$('#album_limit').change(function(){
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
      