<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="material-index">

    <h1><?= Html::encode($this->title) ?>(使用中)</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增'.$this->title, ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
			 'header' => '操作',
			 'template' =>'{view} {update} {delete}',
			 'buttons' => [
				 'delete'=>function ($url, $model, $key) {
					 if($model->id == 0){
						 return '';
					 }else{
						 return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['nouse', 'id' => $model->id], ['data'=>['confirm'=>'你確定要將此材料停用嗎?']]);
					 }
				 },
				 'update'=>function ($url, $model, $key) {
					 if($model->id == 0){
						 return '';
					 }else{
						 return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id]);
					 }
				 },
				 'view'=>function ($url, $model, $key) {
					 if($model->id == 0){
						 return '';
					 }else{
						 return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id]);
					 }
				 }]
			],        ],
    ]); ?>
</div>
