$(document).ready(function(){
	/* Nomenclature **************/
	var label= $('label');
	var content= $('.content');
	
	/* Default values ***********/
	$('i.i-right2:first').show();
	$('i.i-right1:first').hide();
	$('.content').not(":first").hide();
	
	/* Mouse click (label)****/
	$('label').on("click",function(){
		/* Nomenclature **************/
		var tLabel = $(this);
		var tContent = tLabel.next();
		
		/* Default values ***********/
		$('i.i-right1').show();
		$('i.i-right2').hide();
		
		content.slideUp("normal");
		tContent.slideDown("slow");
		
		/* Hide and show right icon */
		$(tLabel).children('i.i-right1').hide();
		$(tLabel).children('i.i-right2').show();
		
		/* Open and close content */
		if(tContent.is(":visible")) {
			return;
		}
		
	});
});