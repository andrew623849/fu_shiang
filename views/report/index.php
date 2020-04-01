<?php

	use kartik\tabs\TabsX;

	/* @var $this yii\web\View */
	/* @var $searchModel app\models\AdminsheetSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */

	$this->title = '報表';
	$this->params['breadcrumbs'][] = $this->title;

	$items = [
		[
			'label'=>'周報表',
			'content'=>Yii::$app->runAction('report/week-report'),
		],
		[
			'label'=>'月報表',
			'content'=>Yii::$app->runAction('report/month-report'),
		],
//		[
//			'label'=>'年報表',
//			'content'=>Yii::$app->runAction('report/year-report'),
//		],
	];
	if(!empty($_POST['type'])){
		$items[$_POST['type']]['active'] = true;
	}else{
		$items[0]['active'] = true;
	}
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);
?>