
<?php

	use app\models\frontpageSearch;
	use app\models\Systemsetup;
	use yii\helpers\Html;
	use app\assets\frontAsset;
	use yii\web\View;

	$sys_name = Systemsetup::SysName();
	$page = frontpageSearch::GetDataWhere(['deleted'=>0]);
	$dir = './users/'.explode('_',Yii::$app->db->dsn)[1].'/home_img';

	$handle = @opendir($dir) or die("Cannot open " . $dir);
	// 用 readdir 讀取檔案內容
	while($file = readdir($handle)){
		if($file != "." && $file != ".."){
			$file_arr[] =  '../'.$dir.'/'.$file;
		}
	}
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
		frontAsset::register(Yii::$app->view, \yii\web\View::POS_HEAD);
	?>
	<style>
		#skel-layers-inactiveWrapper{
			height:0!important;
		#header{
			background: #ddff73 url(<?php echo $file_arr[0]??''?>) no-repeat;

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
						echo '<li><a href="/site/pages?op='.$val['file_name'].'">'.$val['name'].'</a></li>';
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
<?php
if(!empty($file_arr)){
	$file_string = implode(",",$file_arr);
$js = <<<JS
	var k = 0;
	var file_arr = "{$file_string}".split(',');
	function header_auto(){
		setTimeout(function() {
			if(k+1 == file_arr.length){
				k=0;
			}else{
				k++;
			}
			header_auto();
			$("#header").css('background-image',"url("+file_arr[k]+")");
		},5000);
	}
	header_auto();


JS;
	$this->registerJs($js, View::POS_END);
}

	$this->endPage();
?>
