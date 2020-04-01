<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="material-index">
	<h1><?= Html::encode($this->title) ?>(未使用)</h1>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'material',
			'price',
			[
				'attribute'=>'build_time',
				'value'=>function($data){
					return  date('Y-m-d',strtotime($data->build_time));
				}
			],
			//'deleted',
			//'useable',
			//'modify_time',

			['class' => 'yii\grid\ActionColumn',
			 'template' =>'{use}',
			 'buttons' => [
				 'use'=>function ($url, $model, $key) {
					 return Html::a('使用', ['use', 'id' => $model->id], ['class' => "btn btn-success btn-sm",'data'=>['confirm'=>'你確定要將此材料放入使用區嗎?']]);
				 }
			 ]],
			],
	]); ?>
</div>
