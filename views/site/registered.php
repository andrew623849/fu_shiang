<?php

use kartik\label\LabelInPlace;
use yii\helpers\Html;use yii\widgets\ActiveForm;
$form = ActiveForm::begin([
	'action' => ['register'],
	'method' => 'post',
]); ?>
<div class="col-md-6">
	<h3 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">註冊資料</h3>
	<?= LabelInPlace::widget(['name'=>'company_name', 'label'=>'公司名稱','options' => ['style'=>'margin:15px 0','required'=>'required']]); ?>
	<?= LabelInPlace::widget(['name'=>'companyer', 'label'=>'負責人','options' => ['style'=>'margin:15px 0','required'=>'required']]); ?>
	<?= LabelInPlace::widget(['name'=>'admin', 'label'=>'登入帳號','options' => ['style'=>'margin:15px 0','required'=>'required']]); ?>
	<?= LabelInPlace::widget(['name'=>'password', 'label'=>'登入密碼','options' => ['style'=>'margin:15px 0','required'=>'required']]); ?>
	<?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>