<?php

	use app\models\AdminsheetSearch;
	use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Material;
use mludvik\tagsinput\TagsInputWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Material */
/* @var $form yii\widgets\ActiveForm */
$max = Material::find()->orderBy('id DESC')->Asarray()->one();
$admin_data = AdminsheetSearch::GetUserData();

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

	<div id="make_processer">
		<?php if(!empty($model['make_process'])){
			$html = '';
			$make_process = explode(',',$model['make_process']);
			$maker_process = explode(',',$model['maker_process']);
			foreach($make_process as $key => $val){
				$html .= '<div class="form-group col-sm-4 maker_process_div">' .
					'<label class="control-label">'.$val.'</label>' .
					'<select class="form-control maker_process">';
				foreach($admin_data as $k=>$v){
					$html .= '<option '.($maker_process[$key] == $v['id']?"selected":'').' value="'. $v['id'] .'">' . $v['user_name'] .'</option>';
				}
				$html .= '</select></div>';
			}
			echo $html;
		 }?>

	</div>
	<?= $form->field($model, 'id')->label("")->hiddenInput(['value' => ($max['id']+1)]) ?>
	<?= $form->field($model, 'sort')->label("")->hiddenInput(['value' => ($max['id']+1)]) ?>
	<?= $form->field($model, 'build_time')->label("")->hiddenInput(['value' => date('Y-m-d H:i:s')]) ?>
	<?= $form->field($model, 'maker_process')->label("")->hiddenInput() ?>
    <div class="form-group col-sm-12">
        <?= Html::Button('送出', ['class' => 'btn btn-success submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = 'var admin_data = '.json_encode($admin_data).';';

$js .= <<<JS

	$(".submit").on('click',function() {
		var maker_p = [];
		$(".maker_process").each(function() {
			maker_p.push($(this).val());
		});
		$("input[name ='Material[maker_process]']").val(maker_p.join(','));
		$("#w0").submit();
	});
	$("input[name ='Material[make_process]']").on('change',function() {
	  var make_p = $(this).val().split(',');
	  $('.maker_process_div').each(function() {
	  	if(make_p.indexOf($(this).find('label').html()) == -1){
	  		$(this).remove();
	  	}
	  });
	  html = '';
	  for(key in make_p){
	  	if(make_p[key] != $('.maker_process_div').eq(key).find('label').html()){
	  		html += '<div class="form-group col-sm-4 maker_process_div">' +
					'<label class="control-label">'+make_p[key]+'</label>' + 
					'<select class="form-control maker_process">';
						for(akey in admin_data){
							html += '<option value="'+ admin_data[akey]['id'] +'">' + admin_data[akey]['user_name'] +'</option>';
						}
				html += '</select></div>';
	  	}
	  }
	  $("#make_processer").html($("#make_processer").html()+html);

	});
JS;
$this->registerJs($js);
