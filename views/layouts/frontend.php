
<?php

	use app\models\frontpageSearch;
	use app\models\Systemsetup;
	use yii\helpers\Html;
	use app\assets\frontAsset;

	$sys_name = Systemsetup::SysName();
	$page = frontpageSearch::GetDataWhere(['deleted'=>0]);
?>
<?php $this->beginPage() ?>

<!DOCTYPE HTML>
<html>
<head>
	<title><?= $sys_name?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<?php $this->registerCsrfMetaTags() ?>

	<?php
		$this->head();
		frontAsset::register($this);
	?>
	<style>
		#skel-layers-inactiveWrapper{
			height:0!important;
		}
	</style>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Header -->
<div id="header">
	<div class="container">

		<!-- Logo -->
		<h1><a href="" id="logo"><?= $sys_name?></a></h1>

		<!-- Nav -->
		<nav id="nav">
			<ul>
				<li><a href="/site/index">首頁</a></li>
				<?php
					foreach($page as $val){
						echo '<li><a href="/site/pages?'.$val['file_name'].'">'.$val['name'].'</a></li>';
					}
				?>
			</ul>
		</nav>


		<!-- Banner -->
		<div id="banner">
			<div class="container">
				<section>
					<?php if(explode('_',Yii::$app->db->dsn)[1] == 'main'){
						echo Html::a('註冊', ['site/registered'],['class'=>"button alt"]);
					}?>
				</section>
			</div>
		</div>
	</div>
</div>
<?= $content ?>

<!-- Footer-->
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
