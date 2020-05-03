<?php

use kriss\swiper\SwiperWidget;
use yii\helpers\Html;

$dir = $model->home_file.'/home_img';
// 用 opendir() 開啟目錄，開啟失敗終止程式
$handle = @opendir($dir) or die("Cannot open " . $dir);

// 用 readdir 讀取檔案內容
while($file = readdir($handle)){
	if($file != "." && $file != ".."){
		$file_arr[] =  Html::img('../'.$dir.'/'.$file,['style'=>'height:300px;width:100%']);
	}
}
$swiperEl = 'swiper';

if(!empty($file_arr)){
	echo '<div class="wrapper style2" style="padding-bottom: 0px;padding-top: 0px;">
				<section class="container" style="width:100%!important;padding-top: 20px;padding-bottom: 20px;margin-right: 0px;margin-left: 0px;">';
	echo SwiperWidget::widget([
		'slides' => $file_arr,
		'pagination' => false,
		'navigation' => true,
		'scrollbar' => false,
		'swiperEl' => $swiperEl,
		'clientOptions' => [
			'slidesPerView'=> 4,
			'spaceBetween' => 10,
			'speed' => 200,
			'loop' => true,
			'breakpoints'=> [
				'640'=>[
					'slidesPerView'=> 1,
					'spaceBetween' => 10,
				],
				'1024'=>[
					'slidesPerView'=> 3,
					'spaceBetween' => 10,
				],
			]
		]
	]);
	echo '</section>
	</div>';
}

?>

<div id="main" class="wrapper style1">
	<section class="container">
<?php
require_once($model->home_file.'/homepage.html');
?>
	</section>
</div>
<?php
$js = <<<JS
	$('#w0-swiper-container').click(function() {
		{$swiperEl}.slideNext();
	});
	function swiperE1_auto(){
		setTimeout(function(){
			{$swiperEl}.slideNext();
			swiperE1_auto();
		},5000);
	}
	swiperE1_auto();
	{$swiperEl}.slidesPerView=3;

JS;
	$this->registerJs($js);
?>
