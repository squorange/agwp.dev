function essbasc_popup_show() {
	jQuery.fn.extend({
        center: function () {
            return this.each(function() {
                var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
                var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
                jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
            });
        }
    }); 
	
	
	var win_width = jQuery( window ).width();
	var doc_height = jQuery('document').height();
	
	var base_width = 800;
	var userwidth = jQuery('.essbasc-popup').attr("data-popup-width");
	if (Number(userwidth) && Number(userwidth) > 0) {
		base_width = userwidth;
	}
	
	if (win_width < base_width) { base_width = win_width - 60; }	
	
	jQuery(".essbasc-popup").css( { width: base_width+'px'});
	jQuery(".essbasc-popup").center();
	jQuery(".essbasc-popup").show();		
	jQuery(".essbasc-popup-shadow").show();
	
}

function essbasc_popup_close() {
	jQuery(".essbasc-popup").css( { display: 'none'});		
	jQuery(".essbasc-popup-shadow").css( { display: 'none'});
}
