<?php

	use yii\helpers\Html;
	use yii\grid\GridView;
	use app\models\Level;
	use yii\helpers\ArrayHelper;

	/* @var $this yii\web\View */
	/* @var $searchModel app\models\AdminsheetSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="admin-sheet-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name',
			'build_time',
			['class' => 'yii\grid\ActionColumn',
			 'header' => '操作',
			 'template' =>'{update} {delete}',
			 'buttons' => [
				 'delete'=>function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-page', 'id' => $model->id], ['data'=>['confirm'=>'你確定要將此文章嗎?']]);
				 },
				 'update'=>function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id]);
				 },
				]
			],
		],
	]); ?>
</div>
