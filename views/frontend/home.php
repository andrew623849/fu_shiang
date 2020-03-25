
<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$form = ActiveForm::begin([
	'action' => ['frontend/edit'],
	'method' => 'post',
	'options' => [
		'enctype'=>'multipart/form-data',
	]


]);
$file_input_popion = [
	'initialPreviewAsData'=>true,
	'showPreview' => true,
	'showRemove' => false,
	'showUpload' => false,
	'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
	'browseLabel' =>  '上傳照片',
	'overwriteInitial'=> true,
	'deleteUrl' => "/frontend/deleted",
];
if(!empty($model->file_arr)){
	$file_input_popion['initialPreview'] = $model->file_arr;
}
if(!empty($model->file_config)){
	$file_input_popion['initialPreviewConfig'] = $model->file_config;
}
echo Html::submitButton('完成編輯',['class' => 'btn btn-success submit_b','style'=>'margin:10px;']);
echo '<div class="row">';
echo $form->field($model,'imageFile[]')->label("輪番圖片")->widget(FileInput::className(),[
	'options'=>[
		'multiple'=>true,
		'style'=>'overflow-x: scroll;'
	],
	'pluginOptions' => $file_input_popion
]);
echo '</div>';
echo $form->field($model,'text')->label("首頁內文")->widget(CKEditor::className(),[
        'preset' => 'custom',
//		'kcfinder' => true,
		'clientOptions' => [
			'height' => 800,

		],
    ]) ?>
<?php ActiveForm::end();

$js=<<<JS
	$('input[name="UploadForm[imageFile][]"]').change(function() {
		setTimeout(function(){
			$('.submit_b').click();	
		},100);
	});
JS;
$this->registerJs($js);