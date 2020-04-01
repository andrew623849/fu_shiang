<?php

	use kartik\tabs\TabsX;

	/* @var $this yii\web\View */
	/* @var $searchModel app\models\AdminsheetSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */

	$this->title = '材料';
	$this->params['breadcrumbs'][] = $this->title;
	$items = [
		[
			'label'=>'使用中',
			'active'=>true,
			'content'=>Yii::$app->runAction('material/useable'),
		],
		[
			'label'=>'未使用',
			'content'=>Yii::$app->runAction('material/no-useable'),
		],
	];
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);
?>
