<?php

use kriss\swiper\SwiperWidget;
use yii\helpers\Html;

$dir = $model->home_file.'/home_img';
// 用 opendir() 開啟目錄，開啟失敗終止程式
$handle = @opendir($dir) or die("Cannot open " . $dir);

// 用 readdir 讀取檔案內容
while($file = readdir($handle)){
	if($file != "." && $file != ".."){
		$file_arr[] =  Html::img('../'.$dir.'/'.$file,['height'=>400]);
	}
}
$swiperEl = 'swiper';
if(!empty($file_arr)){
	echo SwiperWidget::widget([
		'slides' => $file_arr,
		'pagination' => true,
		'navigation' => true,
		'scrollbar' => false,
		'swiperEl' => $swiperEl,
		'clientOptions' => [
			'speed' => 200,
			'loop' => true,
		]
	]);
}

?>
<?php
require_once($model->home_file.'/homepage.html');
?>
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

JS;
	$this->registerJs($js);
?>
