var Lock = function () {

    return {
        //main function to initiate the module
        init: function () {

             $.backstretch([
		        "themes/1/closeweb/assets/admin/pages/media/bg/1.jpg",
    		    "themes/1/closeweb/assets/admin/pages/media/bg/2.jpg",
    		    "themes/1/closeweb/assets/admin/pages/media/bg/3.jpg",
    		    "themes/1/closeweb/assets/admin/pages/media/bg/4.jpg"
		        ], {
		          fade: 1000,
		          duration: 8000
		      });
        }

    };

}();