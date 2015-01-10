// On document ready:

$(function(){

	// Instantiate MixItUp:

	$('#Container').mixItUp();

});


// Swipebox

$( document ).ready(function() {
		/* Basic Gallery */
		$( '.swipebox' ).swipebox();		
		/* Video */
		$( '.swipebox-video' ).swipebox();
    });
		

//	Simple Text Rotator	
		
$(".rotate").textrotator({
        animation: "dissolve",
        separator: ",",
    speed: 2000
    });		