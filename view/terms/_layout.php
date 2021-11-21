<!DOCTYPE html>
<html lang="en">

<head>
	<link href="https://fonts.loli.net/css?family=Noto+Sans+SC:300,400&display=swap&subset=chinese-simplified"
		rel="stylesheet">
	<script>
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({
			'isLoggedIn': 'true'
		});
	</script>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Terms</title>
	<meta name="description" content="Ichi" />
	<meta name="robots" content="noindex,follow" />
	<link href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://www.websitepolicies.com/assets/css/web/policies/view.min.css" rel="stylesheet"
		type="text/css" />
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://unpkg.com/js-cookie"></script>
	<script type="text/javascript" src="/js/bg-color.js"></script>
	<link href="https://unpkg.com/flag-icon-css@3.4.5/css/flag-icon.min.css" rel="stylesheet">

	<style>
		
		body {
			font-family: 'Noto Sans SC', sans-serif;
		}
		
		.user {
			background: #fff;
		}

		#header .container {
			background: transparent !important;
		}

		#header {
			background-image: var(--main-color) !important;
		}

		#footer .container {
			background-color: transparent !important;
			border-top: none !important;
			padding-bottom: 0px !important;
			padding-top: 0px !important;
		}

		#footer {
			background-color:
				#F0F0F0;
			border-top: 1px solid #E0E0E0;
			color:
				#333;
			padding-bottom: 20px;
			padding-top: 20px;
		}

		.select {
			outline: none;
			border-radius: 2px;
			padding: 13px 18px 13px 18px;
			font-size: 1rem;
			color: #000;
			border: none;
			box-sizing: border-box;
			font-weight: 500;
			transition: .25s all;
			box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .2);
			appearance: none;
			-moz-appearance: none;
			-webkit-appearance: none;
			padding-right: 30px;
			background-color: #fff;
			margin-bottom: 10px;
			height: inherit;
			font-weight: 500;
		}

		.container{
			margin-bottom: 20px; 
		}
	</style>
</head>

<body class="user">
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-ms-12">
					<h1><span>Ichi</span></h1>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-ms-12">
				<select class="select custom-select" id="language">
					<option value="en" data-thumbnail="https://unpkg.com/browse/flag-icon-css@3.4.5/flags/4x3/us.svg">
						English
					</option>
					<option value="zh">简体中文</option>
					<option value="zht">繁體中文</option>
				</select>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-ms-12">
				<article>

					<?php echo $body ?>

				</article>
			</div>
		</div>
	</div>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-ms-12">
					<a target="_blank" rel="nofollow">Ichi</a> <?php echo date('Y') ?></div>
			</div>
		</div>
	</footer>

	<script src=https://unpkg.com/dom-i18n/dist/dom-i18n.min.js> </script> <script>
		i18n = domI18n({
			selector: 'p, h2, h3',
			languages: ['en', 'zh', 'zht'],
			enableLog: false
		});
		$('#language').click(function () {
			i18n.changeLanguage($(this).val());
		});

	</script>
</body>

</html>