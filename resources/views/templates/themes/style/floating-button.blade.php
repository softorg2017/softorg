<!DOCTYPE html>
<!-- saved from url=(0068)http://demo.sc.chinaz.com//Files/DownLoad/webjs1/201611/jiaoben4660/ -->
<html lang="zh" style="">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Floating-Button</title>


		<link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/ionicons.min.css') }}" />

		<script src="{{ asset('templates/themes/floating-button/modernizr.touch.js') }}"></script>

		<link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/index.css') }}" />
		<link type="text/css" rel="stylesheet" href="{{ asset('templates/themes/floating-button/mfb.css') }}" />
	</head>


<body>
<ul id="menu" class="mfb-component--br mfb-slidein " data-mfb-toggle="hover" style="display: block;">
	<li class="mfb-component__wrap">

		<a href="javascript:void(0)" class="mfb-component__button--main">
			<i class="mfb-component__main-icon--resting ion-plus-round"></i>
			<i class="mfb-component__main-icon--active ion-close-round"></i>
		</a>

		<ul class="mfb-component__list">
			<li>
				<a href="javascript:void(0)" data-mfb-label="View on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-github"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="Follow me on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-octocat"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="Share on Twitter" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-twitter"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="返回首页" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-twitter"></i>
				</a>
			</li>
		</ul>

	</li>
</ul>
<ul id="menu" class="mfb-component--tr mfb-zoomin " data-mfb-toggle="hover" style="display: block;">
	<li class="mfb-component__wrap">

		<a href="javascript:void(0)" class="mfb-component__button--main">
			<i class="mfb-component__main-icon--resting ion-plus-round"></i>
			<i class="mfb-component__main-icon--active ion-close-round"></i>
		</a>

		<ul class="mfb-component__list">
			<li>
				<a href="javascript:void(0)" data-mfb-label="View on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-github"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="Follow me on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-octocat"></i>
				</a>
			</li>
		</ul>

	</li>
</ul>
<ul id="menu" class="mfb-component--tl mfb-slidein-spring " data-mfb-toggle="hover" style="display: block;">
	<li class="mfb-component__wrap">

		<a href="javascript:void(0)" class="mfb-component__button--main">
			<i class="mfb-component__main-icon--resting ion-plus-round"></i>
			<i class="mfb-component__main-icon--active ion-close-round"></i>
		</a>

		<ul class="mfb-component__list">
			<li>
				<a href="javascript:void(0)" data-mfb-label="View on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-github"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="Follow me on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-octocat"></i>
				</a>
			</li>
		</ul>

	</li>
</ul>
<ul id="menu" class="mfb-component--bl mfb-fountain " data-mfb-toggle="hover" style="display: block;">
	<li class="mfb-component__wrap">

		<a href="javascript:void(0)" class="mfb-component__button--main">
			<i class="mfb-component__main-icon--resting ion-plus-round"></i>
			<i class="mfb-component__main-icon--active ion-close-round"></i>
		</a>

		<ul class="mfb-component__list">
			<li>
				<a href="javascript:void(0)" data-mfb-label="View on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-github"></i>
				</a>
			</li>

			<li>
				<a href="javascript:void(0)" data-mfb-label="Follow me on Github" class="mfb-component__button--child">
					<i class="mfb-component__child-icon ion-social-octocat"></i>
				</a>
			</li>
		</ul>

	</li>
</ul>

<section id="panel" class="panel viewCode">
	<header>
		<h1>Material Floating Buttons</h1>
		<span id="showcode" class="showcode">
			<i class="ion-eye icon-yepcode"></i>
			<i class="ion-eye-disabled icon-nocode"></i>
		</span>
	</header>
	<article>
		<p>
			<select id="selections-fx">
				<option value=" mfb-zoomin " selected="">Zoom in</option>
				<option value=" mfb-slidein ">Slide in</option>
				<option value="  mfb-slidein-spring ">Slide in (spring)</option>
				<option value=" mfb-fountain ">Fountain</option>
			</select>

			<select id="selections-pos">
				<option value="mfb-component--tl ">top left</option>
				<option value="mfb-component--tr ">top right</option>
				<option value="mfb-component--bl ">bottom left</option>
				<option value="mfb-component--br " selected="">bottom right</option>
			</select>
		</p>
	</article>
</section>


<script src="{{ asset('templates/themes/floating-button/mfb.js') }}"></script>
<script type="text/javascript">
	var panel = document.getElementById('panel'),
		menu = document.getElementById('menu'),
		showcode = document.getElementById('showcode'),
		selectFx = document.getElementById('selections-fx'),
		selectPos = document.getElementById('selections-pos'),
		// demo defaults
		effect = 'mfb-zoomin',
		pos = 'mfb-component--br';

	showcode.addEventListener('click', _toggleCode);
	selectFx.addEventListener('change', switchEffect);
	selectPos.addEventListener('change', switchPos);

	function _toggleCode() {
	  panel.classList.toggle('viewCode');
	}

	function switchEffect(e){
	  effect = this.options[this.selectedIndex].value;
	  renderMenu();
	}

	function switchPos(e){
	  pos = this.options[this.selectedIndex].value;
	  renderMenu();
	}

	function renderMenu() {
	  menu.style.display = 'none';
	  // ?:-)
	  setTimeout(function() {
		menu.style.display = 'block';
		menu.className = pos + effect;
	  },1);
	}
</script>


</body></html>