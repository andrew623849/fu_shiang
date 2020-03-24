<?php

use kartik\tabs\TabsX;
if(!empty($model->errors)){
	p_r($model->errors);
}
// Above
	$items = [
		[
			'label'=>'首頁編輯',
			'active'=>true,
			'content'=>Yii::$app->runAction('frontend/home'),
		],
//		[
//			'label'=>'分頁編輯',
//			'content'=>Yii::$app->runAction('frontend/home'),
//		],
	];
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);