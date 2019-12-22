<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Outlay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outlay-form">

    <?php $form = ActiveForm::begin(); ?>
   	<div class="form-group col-sm-12">
    	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
    <div class="form-group col-sm-6">
    	<?= $form->field($model, 'buy_time')->label("*支付時間")->widget(DatePicker::classname(), [
			'type' => DatePicker::TYPE_INPUT,
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
			]
  	  	]); ?>
    </div>
    <div class="form-group col-sm-6">
    	<?= $form->field($model, 'pay_mny')->label("*支出金額")->textInput() ?>
	</div>
    <div class="form-group col-sm-1">
        <?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
