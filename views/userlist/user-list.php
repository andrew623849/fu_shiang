<?php

	use yii\helpers\Html;
	use yii\grid\GridView;

?>

<div class="admin-sheet-index">

	<h1>用戶名單</h1>
	<p>
		<?= Html::a('新增用戶', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'code',
			'company_name',
			'user_name',
			'user_admin',
			'user_mny',
			'start_time',
			'end_time',
		],
	]); ?>
</div>
