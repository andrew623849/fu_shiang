<?php

use kriss\swiper\SwiperWidget;
use yii\helpers\Html;

$swiperEl = 'swiper';
echo SwiperWidget::widget([
	'slides' => [
		Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
		Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
		Html::img('http://img.zcool.cn/community/01665258173c34a84a0d304fc68fdf.jpg'),
	],
	'pagination' => true,
	'navigation' => true,
	'scrollbar' => false,
	'swiperEl' => $swiperEl,
	'clientOptions' => [
		'speed' => 200,
		'loop' => true,
	]
]);

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
