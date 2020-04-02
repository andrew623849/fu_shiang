
<?php

use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminsheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '超級管理員';
$this->params['breadcrumbs'][] = $this->title;
	$items = [
		[
			'label'=>'用戶名單',
			'active'=>true,
			'content'=>Yii::$app->runAction('userlist/user-list'),
		],
		[
			'label'=>'資料庫編修',
			'content'=>Yii::$app->runAction('userlist/sql-edit'),
		],
	];
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);
?>
