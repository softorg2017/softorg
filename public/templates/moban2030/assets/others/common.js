// JavaScript Document
 $(function(){
	$('.hlzb').hover(function(){
		$dropdown=$(this).attr('drop-down');
		$('.'+$dropdown).show();
		$count=$('.'+$dropdown+' .d_menu a').length;
		$('.'+$dropdown+' .d_menu').animate({"height":$count*40+'px'},200);
	},function(){
		$('.'+$dropdown).hide();
		$('.'+$dropdown+' .d_menu').css("height",'8px');
	})
	$('.downlist').hover(function(){
		$index=$(this).index();
		//alert($index);
		$('.downlist'+$index).show();
		$count=$('.downlist'+$index+' .d_menu a').length;
		$('.downlist'+$index+' .d_menu').animate({"height":$count*40+'px'},0);
	},function(){
		$('.downlist'+$index).hide();
		$('.downlist'+$index+' .d_menu').css("height",'8px');
	})
})