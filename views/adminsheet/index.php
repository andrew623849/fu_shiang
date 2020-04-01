<?php

use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminsheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '員工';
$this->params['breadcrumbs'][] = $this->title;
	$items = [
		[
			'label'=>'在職員工',
			'active'=>true,
			'content'=>Yii::$app->runAction('adminsheet/work'),
		],
		[
			'label'=>'離職員工',
			'content'=>Yii::$app->runAction('adminsheet/work-leave'),
		],
	];
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);
?>
