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
	$sql_data[$sql_title.$val['code']] = $sql_title.$val['code'];
}
$sql_data[$sql_title.'main'] = $sql_title.'main';
$sql_data[$sql_title.'sample'] = $sql_title.'sample';
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
				<?php echo Html::Button('語法產生',['class'=> 'btn btn-success','onclick'=>'sqlcreate()']);?>
			</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">產生語法</label>
		<div class="col-md-10">
			<textarea name="create_sql" rows="6" style="width: 100%;resize: vertical;"></textarea>
		</div>
	</div>
<?php

$js=<<<JS
	function new_multi_select_all(){
		$('#new_multi_select1').multiSelect('select_all');
	}
	function new_multi_deselect_all(){
		$('#new_multi_select1').multiSelect('deselect_all');
	}
	function sqlcreate(){
		var this_sql_string = $("textarea[name=sql_string]").val();
		var select_db = $('#new_multi_select1').val();
		if(this_sql_string.indexOf("#database") != -1 && select_db){
			var create_sql_string = '';
			for(var i = 0 ; i < select_db.length ; i++){
				create_sql_string += this_sql_string.replace(new RegExp("#database","g"),select_db[i]);
				if((select_db.length-1) != i)
					create_sql_string += "\\n";
			}
			$("textarea[name=create_sql]").val(create_sql_string);
		}else
			$("textarea[name=create_sql]").val(this_sql_string);
	}
JS;
$this->registerJs($js, View::POS_END);