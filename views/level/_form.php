<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\LevelSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Level */
/* @var $form yii\widgets\ActiveForm */
$level_labels = LevelSearch::LevelLabels();
?>

<div class="level-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'job_name')->textInput(['maxlength' => true]) ?>
	<div class="form-group">
		<label>職權</label>
		<table class="table">
			<thead>
			<tr>
				<th scope="col">查看</th>
				<th scope="col">新增</th>
				<th scope="col">編輯</th>
				<th scope="col">刪除</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($level_labels as $key=>$val){
				$decbin = preg_split('//', decbin($model[$key]), -1, PREG_SPLIT_NO_EMPTY);

			?>
				<tr>
					<td><?= $val?><input type="checkbox" id="<?= $key?>" <?= ((!empty($decbin[0]) && $decbin[0] == 1) || empty($decbin[0]))?'checked':''?>></td>
					<td><input type="checkbox" id="<?= $key?>_new" <?= ((!empty($decbin[1]) && $decbin[1] == 1) || empty($decbin[1]))?'checked':''?> <?= ($decbin[0] == 1 || empty($decbin[0]))?'':'disabled'?>></td>
					<td><input type="checkbox" id="<?= $key?>_edit" <?= ((!empty($decbin[2]) && $decbin[2] == 1) || empty($decbin[2]))?'checked':''?> <?= ($decbin[0] == 1 || empty($decbin[0]))?'':'disabled'?>></td>
					<td><input type="checkbox" id="<?= $key?>_del" <?= ((!empty($decbin[3]) && $decbin[3] == 1) || empty($decbin[3]))?'checked':''?> <?= ($decbin[0] == 1 || empty($decbin[0]))?'':'disabled'?>></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	<?php foreach($level_labels as $key=>$val){ ?>
		<input type="hidden" name="Level[<?=$key?>]" id="level-<?=$key?>" value="<?= !empty($model[$key])?$model[$key]:15?>">
	<?php }?>
    <div class="form-group">
        <?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = '';
foreach($level_labels as $key=>$val){
	$js .= <<< JS
			$('#$key').click(function() {
			   if($("#$key").prop("checked")) {
			   		$("#level-$key").val(15);
					$("#$key" + "_new").attr('disabled',false);
					$("#$key" + "_edit").attr('disabled',false);
					$("#$key" + "_del").attr('disabled',false);
					$("#$key" + "_new").attr('checked',true);
					$("#$key" + "_edit").attr('checked',true);
					$("#$key" + "_del").attr('checked',true);
			   }else{
					$("#level-$key").val(0);
					$("#$key" + "_new").attr('disabled',true);
					$("#$key" + "_edit").attr('disabled',true);
					$("#$key" + "_del").attr('disabled',true);
					$("#$key" + "_new").removeAttr('checked');
					$("#$key" + "_edit").removeAttr('checked');
					$("#$key" + "_del").removeAttr('checked');
			   }
			});
			$('#$key' + "_new").click(function() {
			   if($("#$key" + "_new").prop("checked")) {
			   		$("#level-$key").val(parseInt ($("#level-$key").val())+4);
			   }else{
					$("#level-$key").val(parseInt ($("#level-$key").val())-4);
			   }
			});
			$('#$key' + "_edit").click(function() {
			   if($("#$key" + "_edit").prop("checked")) {
			   		$("#level-$key").val(parseInt ($("#level-$key").val())+2);

			   }else{
					$("#level-$key").val(parseInt ($("#level-$key").val())-2);
			   }
			});
			$('#$key' + "_del").click(function() {
			   if($("#$key" + "_del").prop("checked")) {
			   		$("#level-$key").val(parseInt ($("#level-$key").val())+1);

			   }else{
					$("#level-$key").val(parseInt ($("#level-$key").val())-1);
			   }
			});
JS;
}
$this->registerJs($js);
