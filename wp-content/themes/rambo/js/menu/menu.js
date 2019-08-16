jQuery(document).ready(function() {
    if(jQuery(document).width() > 979) {
        jQuery('.nav li.dropdown').hover(function () {
            jQuery(this).addClass('open');
        }, function () {
            jQuery(this).removeClass('open');
        });
    }else{

        jQuery('.nav li.dropdown').click(function () {
        	if(jQuery(this).hasClass('open')){
                jQuery(this).removeClass('open');
			}else {
                jQuery(this).addClass('open');
			}
        });
	}


	});
	
	  