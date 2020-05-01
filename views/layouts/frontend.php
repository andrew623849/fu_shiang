
<?php

	use app\models\Systemsetup;

	$sys_name = Systemsetup::SysName();

?>
<?php $this->beginPage() ?>

<!DOCTYPE HTML>
<html>
<head>
	<title><?= $sys_name?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="/css/skel.css" />
	<link rel="stylesheet" href="/css/style.css" />
	<!--[if lte IE 8]><script src="/css/ie/html5shiv.js"></script><![endif]-->
	<script src="/js/jquery.min.js"></script>
	<script src="/js/jquery.dropotron.min.js"></script>
	<script src="/js/skel.min.js"></script>
	<script src="/js/skel-layers.min.js"></script>
	<script src="/js/init.js"></script>
	<?php $this->head() ?>

	<!--[if lte IE 8]><link rel="stylesheet" href="/css/ie/v8.css" /><![endif]-->
</head>
<body class="homepage">
<?php $this->beginBody() ?>

<!-- Header -->
<div id="header">
	<div class="container">

		<!-- Logo -->
		<h1><a href="#" id="logo"><?= $sys_name?></a></h1>

		<!-- Nav -->
		<nav id="nav">
			<ul>
				<li><a href="/site/index">首頁</a></li>
			</ul>
		</nav>


		<!-- Banner -->
		<div id="banner">
			<div class="container">
				<section>
					<header class="major">
					</header>
					<a href="#" class="button alt">Sign Up</a>
				</section>
			</div>
		</div>
	</div>
</div>

<?= $content ?>

<!-- Footer -->
<div id="footer">
	<div class="container">
		<!-- Lists -->
		<div class="row">
			<div class="8u">
				<section>
				</section>
			</div>
			<div class="4u">
				<section>
				</section>
			</div>
		</div>
	</div>
</div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
