<?php

use app\models\UserList;
use dosamigos\multiselect\MultiSelectListBox;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$data = UserList::find()->asArray()->all();
$sql_data = [];
$sql_title = 'cowbtool_';
foreach($data as $val){
	$sql_data[] = $sql_title.$val['code'];
}
$sql_data[] = $sql_title.'main';
$sql_data[] = $sql_title.'sample';
$form = ActiveForm::begin([
            'action' => ['/toothcase/pdf'],
            'method' => 'post',
			'options'=>['target'=>'_blank']
        ]);
	$mult_sls = MultiSelectListBox::widget([
		'id' => 'new_multi_select1',
		'name' => 'sql',
		"options" => ['multiple'=>"multiple"], // for the actual multiselect
		'data' => $sql_data, // data as array
		'value' => '', // if preselected
	]);
?>
	<div class="form-group">
		<label class="col-md-2 control-label">選擇資料庫</label>
		<div class="col-md-10">
			<?php echo $mult_sls;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"></label>
		<div class="col-md-10">
			<p>
				<?php echo Html::Button('全選', ['class' => 'btn btn-primary', 'style'=>'margin-top:5px;', 'onclick' => 'new_multi_select_all()']);
					echo Html::Button('取消全選', ['class' => 'btn btn-default', 'style'=>'margin-top:5px;', 'onclick' => 'new_multi_deselect_all()']);?>
			</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">SQL語法</label>
		<div class="col-md-10">
			<textarea name="sql_string" rows="4" style="width: 100%;resize: vertical;"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">取代參數</label>
		<div class="col-md-10">
			<p>
				#database 選擇的資料庫名稱
			</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"></label>
		<div class="col-md-10">
			<p>
				<?php echo Html::SubmitButton('語法產生',['class'=> 'btn btn-success']);?>
			</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">產生語法</label>
		<div class="col-md-10">
			<textarea rows="6" style="width: 100%;resize: vertical;"></textarea>
		</div>
	</div>
<?php
ActiveForm::end();


$js=<<<JS
	function new_multi_select_all(){
		$('#new_multi_select1').multiSelect('select_all');
	}
	function new_multi_deselect_all(){
		$('#new_multi_select1').multiSelect('deselect_all');
	}
JS;
$this->registerJs($js, View::POS_END);