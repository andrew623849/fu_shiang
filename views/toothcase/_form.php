<?php

use app\models\AdminSheet;
use app\models\Material;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\toothcase */
/* @var $form yii\widgets\ActiveForm */
$material_data = Material::find()->where(['or',['and',['=','deleted','0'],['=','useable','0']],['in','id',$model['material_id'].','.$model['material_id_1'].','.$model['material_id_2']]])->indexBy('id')->asArray()->all();
$admin_data = AdminSheet::find()->where(['=','deleted','0'])->indexBy('id')->asArray()->all();
//v_d($material_data);
$material_data[0] = ['material'=>'請選擇'];
ksort($material_data);
?>

<div class="toothcase-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if($url == 'create'){
     $model ->clinic_id = $clinic_this;
}?>
        <div class="form-group col-sm-4" style="height:99px"><?= $form->field($model, 'start_time')->label("*收件日")->widget(DatePicker::classname(), [
			'type' => DatePicker::TYPE_INPUT,
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
			]
    ]); ?></div>
        <div class="form-group col-sm-4" style="height:99px"><?= $form->field($model, 'end_time')->label("*交件日")->widget(DatePicker::classname(), [
			'type' => DatePicker::TYPE_INPUT,
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
			]
    ]); ?></div>
        <div class="form-group col-sm-4" style="height:99px"><?= $form->field($model, 'try_time')->label("試戴日")->widget(DatePicker::classname(), [
			'type' => DatePicker::TYPE_INPUT,
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
			]
    ]); ?></div>
    <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model, 'name')->label("*病人姓名")->textInput(['maxlength' => true]) ?></div>
    <div class="form-group col-sm-6" style="height:99px;"><?= $form->field($model,'clinic_id')->label("*診所")->dropDownList(ArrayHelper::map($clinic_info,'id','clinic'),['style'=>'border:1px solid ;'])?></div>
    <div class="form-group col-sm-12" style="background-color:#E8E8E8;">
		<div class="form-group col-sm-4">
			<?= $form->field($model, 'tooth')->label("*齒位1")->hiddenInput(['maxlength' => true]) ?>
			<?php OpenSVG("tooth"); ?>
		</div>
		<div class="form-group col-sm-8"><?= $form->field($model,'material_id')->label("*材料1")->dropDownList(ArrayHelper::map($material_data,'id','material'),['style'=>'border:1px solid ;'])?>
			<?= $form->field($model, 'tooth_color')->label("齒色")->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'other_price')->label("其他費用")->textInput(['value' => $model['other_price']??0]) ?>
			<div id="material_id_makep">
				<?php
					$html = '';
					if(!empty($model['make_p'])){
						$make_p1 = explode(',',$model['make_p']);
						$material_id_makep = explode(',',$material_data[$model['material_id']]['make_process']);
						foreach($make_p1 as $key=>$val){
							$html .= '<div class="form-group col-sm-4">' .
								'<label class="control-label">'.$material_id_makep[$key].'</label>' .
								'<select class="form-control make_process">';
							foreach($admin_data as $k=>$v){
								$html .= '<option '.($val==$v['id']?'selected':'').' value="'. $v['id'] .'">' . $v['user_name'] .'</option>';
							}
							$html .= '</select></div>';
						}
					}
					echo $html;
				?>
			</div>
		</div>
	</div>
    <div class="form-group col-sm-12 material_id_1" style="background-color:#E8E8E8;" <?php if($model['material_id_1'] == 0){echo 'hidden';$val= "'value'=>0";}else{$val='';}?>>
        <input class="btn btn-danger" style="margin-left: 98.3%;" type="button" id="m_del_btn_1" value="x">
		<div class="form-group col-sm-4">
			<?= $form->field($model, 'tooth_1')->label("*齒位2")->hiddenInput(['maxlength' => true]) ?>
			<?php OpenSVG("tooth1"); ?>
		</div>
		<div class="form-group col-sm-8"><?= $form->field($model,'material_id_1')->label("*材料2")->dropDownList(ArrayHelper::map($material_data,'id','material'),['style'=>'border:1px solid ;'])?>
			<?= $form->field($model, 'tooth_color_1')->label("齒色")->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'other_price_1')->label("其他費用")->textInput(['value' =>  $model['other_price_1']??0]) ?>
			<div id="material_id_1makep">
				<?php
					$html = '';
					if(!empty($model['make_p1'])){
						$make_p1 = explode(',',$model['make_p1']);
						$material_id_1makep = explode(',',$material_data[$model['material_id_1']]['make_process']);
						foreach($make_p1 as $key=>$val){
							$html .= '<div class="form-group col-sm-4">' .
								'<label class="control-label">'.$material_id_1makep[$key].'</label>' .
								'<select class="form-control make_process_1">';
							foreach($admin_data as $k=>$v){
								$html .= '<option '.($val==$v['id']?'selected':'').' value="'. $v['id'] .'">' . $v['user_name'] .'</option>';
							}
							$html .= '</select></div>';
						}
					}
					echo $html;
				?>
			</div>
		</div>
    </div>
    <div class="form-group col-sm-12 material_id_2" style="background-color:#E8E8E8;" <?php if($model['material_id_2'] == 0){echo 'hidden';$val= "'value'=>0";}else{$val='';}?>>
        <input class="btn btn-danger right" style="margin-left:  98.3%;" type="button" id="m_del_btn_2" value="x">
		<div class="form-group col-sm-4">
			<?= $form->field($model, 'tooth_2')->label("*齒位3")->hiddenInput(['maxlength' => true]) ?>
			<?php OpenSVG("tooth2"); ?>
		</div>
		<div class="form-group col-sm-8"><?= $form->field($model,'material_id_2')->label("*材料3")->dropDownList(ArrayHelper::map($material_data,'id','material'),['style'=>'border:1px solid ;'])?>
			<?= $form->field($model, 'tooth_color_2')->label("齒色")->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'other_price_2')->label("其他費用")->textInput(['value' => $model['other_price_2']??0]) ?>
			<div id="material_id_2makep">
				<?php
					$html = '';
					if(!empty($model['make_p2'])){
						$make_p1 = explode(',',$model['make_p2']);
						$material_id_2makep = explode(',',$material_data[$model['material_id_2']]['make_process']);
						foreach($make_p1 as $key=>$val){
							$html .= '<div class="form-group col-sm-4">' .
								'<label class="control-label">'.$material_id_1makep[$key].'</label>' .
								'<select class="form-control make_process_2">';
							foreach($admin_data as $k=>$v){
								$html .= '<option '.($val==$v['id']?'selected':'').' value="'. $v['id'] .'">' . $v['user_name'] .'</option>';
							}
							$html .= '</select></div>';
						}
					}
					echo $html;
				?>
			</div>
		</div>
    </div>
    <input class="col-sm-12 btn btn-primary" type="button" id="m_add_btn" value="新增材料+">
    <div class="form-group col-sm-12"> <?= $form->field($model, 'remark')->label("備註")->textarea(['rows' => '3']) ?></div>
    <div class="form-group col-sm-12"> <?= $form->field($model, 'price')->label("")->hiddenInput(['value' => -1]) ?></div>
    <?= $form->field($model, 'make_p')->label("")->hiddenInput()?>
   	<?= $form->field($model, 'make_p1')->label("")->hiddenInput()?>
    <?= $form->field($model, 'make_p2')->label("")->hiddenInput()?>

	<div class="form-group col-sm-4"><?= Html::Button('提交', ['class' => 'btn btn-success submit']) ?></div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php
$js =<<< JS
    var v = 1;
	var tooth_num = [11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,31,32,33,34,35,36,37,38,41,42,43,44,45,46,47,48];
	$("input[name ='Toothcase[tooth]']").val().split(',').forEach(function(index){
		$("#tooth"+index).css({'visibility': 'hidden'});
	});
	if($("input[name ='Toothcase[tooth_1]']").val() != ''){
		$("input[name ='Toothcase[tooth_1]']").val().split(',').forEach(function(index){
			$("#tooth1"+index).css({'visibility': 'hidden'});
		});
	}
	if($("input[name ='Toothcase[tooth_2]']").val() != ''){
		$("input[name ='Toothcase[tooth_2]']").val().split(',').forEach(function(index){
			$("#tooth2"+index).css({'visibility': 'hidden'});
		});
	}
	
	$('.submit').on('click',function() {
		var make_p = [];
		$('.make_process').each(function() {
			make_p.push($(this).val());
		})
		$("input[name ='Toothcase[make_p]']").val(make_p.join(','));
		var make_p = [];
		$('.make_process_1').each(function() {
			make_p.push($(this).val());
		})
		$("input[name ='Toothcase[make_p1]']").val(make_p.join(','));
		var make_p = [];
		$('.make_process_2').each(function() {
			make_p.push($(this).val());
		})
		$("input[name ='Toothcase[make_p2]']").val(make_p.join(','));
		$('#w0').submit();
	});
	
    $('#m_add_btn').click(function(){
        $('.material_id_'+v).show();
        if(v == 2){
            $('#m_del_btn_1').hide();
            $('#m_add_btn').hide();
        }
        v++;
    });
    $('#m_del_btn_1').click(function(){
        $('.material_id_1').hide();
        $('#toothcase-material_id_1').val(0);
        $('#toothcase-tooth_1').val('');
        $('#toothcase-tooth_color_1').val('');
        $('#toothcase-tooth_color_1').val('');
        $('#material_id_1makep').html('');
      	$('svg').eq(1).find('path').removeAttr('style');
        v = 0;
    });
    $('#m_del_btn_2').click(function(){
        $('.material_id_2').hide();
        $('#m_del_btn_1').show();
        $('#m_add_btn').show();
        $('#toothcase-material_id_2').val(0);
        $('#toothcase-tooth_2').val('');
        $('#toothcase-tooth_color_2').val('');
		$('#material_id_2makep').html('');
      	$('svg').eq(2).find('path').removeAttr('style');

        v = 1;
    });
	
JS;
$js .= 'var make_process = '.json_encode($material_data).';';
$js .= 'var admin_data = '.json_encode($admin_data).';';
$js .= <<< JS
	$("#toothcase-material_id").change(function() {
		make_process_data = make_process[$(this).val()]['make_process'].split(',');
		html = '';
		if(make_process_data != ''){
			for(key in make_process_data){
				html += '<div class="form-group col-sm-4">' +
					'<label class="control-label">'+make_process_data[key]+'</label>' + 
					'<select class="form-control make_process">';
						for(akey in admin_data){
							html += '<option value="'+ admin_data[akey]['id'] +'">' + admin_data[akey]['user_name'] +'</option>';
						}
				html += '</select></div>';
						
			}
		}
	  $("#material_id_makep").html(html);
	});
	$("#toothcase-material_id_1").change(function() {
		make_process_data = make_process[$(this).val()]['make_process'].split(',');
		html = '';
		if(make_process_data != ''){
			for(key in make_process_data){
				html += '<div class="form-group col-sm-4">' +
					'<label class="control-label">'+make_process_data[key]+'</label>' + 
					'<select class="form-control make_process_1">';
						for(akey in admin_data){
							html += '<option value="'+ admin_data[akey]['id'] +'">' + admin_data[akey]['user_name'] +'</option>';
						}
				html += '</select></div>';
						
			}
		}
	  $("#material_id_1makep").html(html);
	});
		$("#toothcase-material_id_2").change(function() {
		make_process_data = make_process[$(this).val()]['make_process'].split(',');
		html = '';
		if(make_process_data != ''){
			for(key in make_process_data){
				html += '<div class="form-group col-sm-4">' +
					'<label class="control-label">'+make_process_data[key]+'</label>' + 
					'<select class="form-control make_process_2">';
						for(akey in admin_data){
							html += '<option value="'+ admin_data[akey]['id'] +'">' + admin_data[akey]['user_name'] +'</option>';
						}
				html += '</select></div>';
						
			}
		}
	  $("#material_id_2makep").html(html);
	});
JS;
$this->registerJs($js);
