<!DOCTYPE html>
<!-- saved from url=(0067)http://demo.sc.chinaz.com/Files/DownLoad/webjs1/201804/jiaoben5873/ -->
<html lang="zh" style="" class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>炫酷CSS3动画库wickedCSS</title>

		<!-- Material Design Icons -->
		<link href="./炫酷CSS3动画库wickedCSS_files/icon" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{url('/templates/themes/wicked/normalize.css')}}"><!--CSS RESET-->
		<link rel="stylesheet" type="text/css" href="{{url('/templates/themes/wicked/demo.css')}}"><!--演示页面样式，使用时可以不引用-->

		<link rel="stylesheet" href="{{url('/templates/themes/wicked/wickedcss.css')}}">
		<link rel="stylesheet" href="{{url('/templates/themes/wicked/style.css')}}">
		<link rel="stylesheet" href="{{url('/templates/themes/wicked/materialize.css')}}">
		<script src="{{url('/templates/themes/wicked/modernizr-2.8.3.min.js')}}"></script>

		</head>


<body>

<div class="container">
	
	<!-- Animation image -->
	  <!-- <div class="section"></div>
	  <div class="section"></div>-->
	  <div class="section"></div>
	  <div class="section"></div> 

	  <div class="container center-align">
		<div class="col s12">
			<div id="animationelement" class="floater"></div>
		</div>
	  </div>

	  <div class="section"></div>
	  <div class="section"></div>

	<div class="container center-align">
		<div class="row">
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="floaterButton">floater</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="barrelRollButton">barrelRoll</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rollerRightButton">rollerRight</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rollerLeftButton">rollerLeft</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="heartbeatButton">heartbeat</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="pulseButton">pulse</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rotationButton">rotation</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="sideToSideButton">sideToSide</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="zoomerButton">zoomer</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="zoomerOutButton">zoomerOut</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="spinnerButton">spinner</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="wiggleButton">wiggle</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="shakeButton">shake</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="poundButton">pound</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="slideUpButton">slideUp</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="slideDownButton">slideDown</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="slideRightButton">slideRight</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="slideLeftButton">slideLeft</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="fadeInButton">fadeIn</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="fadeOutButton">fadeOut</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rotateInRightButton">rotateInRight</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rotateInLeftButton">rotateInLeft</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="rotateInButton">rotateIn</a>
				<div class="section"></div>
			</div>
			<div class="col s12 m3 l2">
				<a href="javascript:void(0)" class="waves-effect waves-light btn-large white blue-text" id="bounceInButton">bounceIn</a>
				<div class="section"></div>
			</div>
		</div>
	</div>
	  
</div>

<script src="{{url('/templates/themes/wicked/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
<script src="{{url('/templates/themes/wicked/materialize.js')}}" type="text/javascript"></script>
<script src="{{url('/templates/themes/wicked/wow.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
 new WOW().init();
</script>

<script type="text/javascript">
/*
BUTTON FUNCTIONS
*/
$('#rotationButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("rotation");
	});
});

$('#sideToSideButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("sideToSide");
	});
});

$('#zoomerButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("zoomer");
	});
});

 $('#zoomerOutButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("zoomerOut");
	});
});

$('#spinnerButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("spinner");
	});
});

 $('#pulseButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("pulse");
	});
});

 $('#shakeButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("shake");
	});
});

 $('#barrelRollButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("barrelRoll");
	});
});

  $('#floaterButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("floater");
	});
});

  $('#wiggleButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("wiggle");
	});
});

  $('#poundButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("pound");
	});
});

$('#rollerRightButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("rollerRight");
	});
});

$('#rollerLeftButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("rollerLeft");
	});
});

$('#heartbeatButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("heartbeat");
	});
});

$('#fadeInButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("fadeIn");
	});
});

$('#fadeOutButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("fadeOut");
	});
});

$('#slideUpButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass(); 
	  $('#animationelement').addClass("slideUp");
	});
});

$('#slideDownButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("slideDown");
	});
}); 

$('#slideLeftButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("slideLeft");
	});
});   

$('#slideRightButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("slideRight");
	});
}); 

$('#rotateInRightButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("rotateInRight");
	});
});

$('#rotateInLeftButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("rotateInLeft");
	});
});

 $('#rotateInButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("rotateIn");
	});
});

 $('#bounceInButton').click(function() {
  $(this).each(function(){
	  $('#animationelement').removeClass();       
	  $('#animationelement').addClass("bounceIn");
	});
});      

</script>

<div style="text-align:center;margin:50px 0; font:normal 14px/24px ';MicroSoft YaHei';;">
<p>适用浏览器：360、FireFox、Chrome、Safari、Opera、傲游、搜狗、世界之窗. 不支持IE8及以下浏览器。</p>
<p>来源：<a href="http://sc.chinaz.com/" target="_blank">站长素材</a></p>
</div>

<div class="hiddendiv common"></div></body></html>