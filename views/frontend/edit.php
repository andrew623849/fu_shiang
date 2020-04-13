<?php

use kartik\tabs\TabsX;

// Above
	$items = [
		[
			'label'=>'首頁編輯',
			'content'=>Yii::$app->runAction('frontend/home'),
		],
		[
			'label'=>'分頁編輯',
			'content'=>Yii::$app->runAction('frontend/pagination'),
		],
	];
if(!empty($_GET))
	$items[$_GET['op']]['active'] = true;
else{
	$items[0]['active'] = true;
}
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);