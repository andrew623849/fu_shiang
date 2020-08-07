
<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kriss\swiper\SwiperWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


$url=Yii::$app->urlManager->createAbsoluteUrl(['frontend/file-upload'],'https');
$form = ActiveForm::begin([
	'action' => ['frontend/edit'],
	'method' => 'post',
	'options' => [
		'enctype'=>'multipart/form-data',
	]


]);
echo Html::submitButton('完成編輯',['class' => 'btn btn-success']);
echo Html::a('前台','/site/index',['class' => 'btn btn-info','target' => "_blank",'style' =>'margin-left:3px;']);
$dir = $model->home_file.'/home_img';
// 用 opendir() 開啟目錄，開啟失敗終止程式
$handle = @opendir($dir) or die("Cannot open " . $dir);

// 用 readdir 讀取檔案內容
$k = 1;
while($file = readdir($handle)){
	if($file != "." && $file != ".."){
		$file_arr[] =  '<label>第'.$k.'張</label><span style="float:right "><button type="button" class="btn btn-danger btn-xs delete-pic" pid="'.($k-1).'">x</button></span>'.Html::img('../'.$dir.'/'.$file,['style'=>'width:100%']);
		$k++;
	}
}

echo $form->field($model,'imageFile[]')->label("輪番圖片")->widget(FileInput::className(),[
	'options'=>[
		'multiple'=>true,
		'style'=>'overflow-x: scroll;'
	],
	'pluginOptions' => [
		'showPreview' => false,
		'showCaption' => true,
		'showRemove' => true,
		'showUpload' => false,
		'browseLabel' =>  '上傳照片',
	]
]);
$swiperEl = 'swiper';
if(!empty($file_arr)){
	echo SwiperWidget::widget([
		'slides' => $file_arr,
		'pagination' => false,
		'navigation' => true,
		'scrollbar' => false,
		'swiperEl' => $swiperEl,
		'clientOptions' => [
			'slidesPerView'=> 4,
			'spaceBetween' => 10,
			'speed' => 200,
			//		'loop' => true,
			'breakpoints'=> [
				'640'=>[
					'slidesPerView'=> 1,
					'spaceBetween' => 10,
				],
				'1024'=>[
					'slidesPerView'=> 3,
					'spaceBetween' => 10,
				],
			]
		]
	]);
}

echo $form->field($model,'text')->label("首頁內文")->widget(CKEditor::className(),[
        'preset' => 'custom',
		'clientOptions' => [
			'language' => 'zh-tw',
			'height' => 800,
			'filebrowserUploadUrl' => $url
		],
    ]) ?>
<?php ActiveForm::end();

$js=<<<JS
	$('.delete-pic').click(function() {
		var pic_link = $(this).parent().parent().find('img').attr('src');
	  {$swiperEl}.removeSlide($(this).attr('pid'));
		$.ajax({
            url: 'deleted',                        // url位置
            type: 'post',                   // post/get
            data: { pic_link: pic_link },       // 輸入的資料
            error: function (xhr) { },      // 錯誤後執行的函數
            success: function (response) {
               
            }// 成功後要執行的函數
        });
	});
JS;
$this->registerJs($js);
