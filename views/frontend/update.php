<?php

	use yii\helpers\Html;

	/* @var $this yii\web\View */
	/* @var $model app\models\Clinic */

	$this->title = '編輯文章';
	$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['edit','op'=>1]];
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'type'=>'update',
	]) ?>

</div>
