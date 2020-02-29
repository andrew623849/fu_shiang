<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Material;
use mludvik\tagsinput\TagsInputWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Material */
/* @var $form yii\widgets\ActiveForm */
$max = Material::find()->orderBy('id DESC')->Asarray()->one();

?>
<style>
	.tags-input{
		width: 100%;!important;
	}
</style>
<div class="material-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="col-sm-6" style="height:99px;">
    	<?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-sm-6" style="height:99px;">
		<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-sm-12" style="height:99px;">
		<?= $form->field($model, 'make_process')->widget(TagsInputWidget::className()) ?>
	</div>
		<?= $form->field($model, 'id')->label("")->hiddenInput(['value' => ($max['id']+1)]) ?>
		<?= $form->field($model, 'sort')->label("")->hiddenInput(['value' => ($max['id']+1)]) ?>
		<?= $form->field($model, 'build_time')->label("")->hiddenInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group col-sm-12">
        <?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
