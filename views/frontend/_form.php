<?php

use app\models\frontpageSearch;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clinic */
/* @var $form yii\widgets\ActiveForm */
	$url=Yii::$app->urlManager->createAbsoluteUrl(['frontend/file-upload']);
	$page = frontpageSearch::GetDataWhere(['deleted'=>0]);
	$page[] = ['id'=>'0','name'=>'無'];
	ksort($page);
?>

<div class="clinic-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="col-md-6">
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-md-6">
		<?= $form->field($model, 'top_id')->dropDownList(ArrayHelper::map($page,'id','name'),['style'=>'border:1px solid ;']) ?>
	</div>
	<?= $form->field($model,'text')->label("首頁內文")->widget(CKEditor::className(),[
		'preset' => 'custom',
		'clientOptions' => [
			'language' => 'zh-tw',
			'height' => 800,
			'filebrowserUploadUrl' => $url
		],
	]) ?>
	<?= $form->field($model, 'build_time')->label("")->hiddenInput(['value'=>date('Y-m-d H:i:s')])?>
	<?= $form->field($model, 'build_id')->label("")->hiddenInput(['value'=>Yii::$app->session['user']['id']])?>
	<?php if($type == 'update'){
		echo $form->field($model, 'modify_time')->label("")->hiddenInput(['value'=>date('Y-m-d H:i:s')]);
		echo $form->field($model, 'modify_id')->label("")->hiddenInput(['value'=>Yii::$app->session['user']['id']]);
	}else{
		echo $form->field($model, 'build_time')->label("")->hiddenInput(['value'=>date('Y-m-d H:i:s')]);
		echo $form->field($model, 'build_id')->label("")->hiddenInput(['value'=>Yii::$app->session['user']['id']]);
	}
	?>
    <div class="form-group">
        <?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
