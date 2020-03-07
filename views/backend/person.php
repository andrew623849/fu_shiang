<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;


$user_arr = Yii::$app->session['user'];

$this->title = $user_arr['user_name'];
?>
<div>
    <h1><?= Html::encode($this->title) ?>
		<?= Html::a('個資修改', ['adminsheet/pupdate', 'id' => $user_arr['id']], ['class' => 'btn btn-primary']) ?>

<?php if(empty($user_arr['line_token'])){
			echo Html::a('LINE連動', ['backend/join-line'], ['class' => 'btn btn-success']);
		}else{
//			echo Html::a('LINE解除', ['backend/leave-line'],['class' => 'btn btn-danger']);
//			echo Html::button('發送LINE', ['class' => 'btn btn-success','id'=>'send_line']);
		}
 ?>
	</h1>
    <?= DetailView::widget([
        'model'=>$user_arr,
        'attributes' => [
            ['label'=>'員工編號','value'=>$user_arr['id']],
            ['label'=>'職稱','value'=>level_name($user_arr['job'])],
            ['label'=>'聯絡方式','value'=>$user_arr['user_phone']],
            ['label'=>'緊急聯絡人','value'=>!empty($user_arr['user_f_ph'])?$user_arr['user_f_na'].'(TEL:'.$user_arr['user_f_ph'].') 關係:'.$user_arr['user_f_rel']:$user_arr['user_f_na'].' 關係:'.$user_arr['user_f_rel']],
            ['label'=>'信箱','value'=>$user_arr['user_email']],
            ['label'=>'學歷','value'=>$user_arr['user_grade']],
            ['label'=>'經歷','value'=>$user_arr['user_exp']],
            ['label'=>'薪資','value'=>$user_arr['user_pay']],
            ['label'=>'到職日','value'=>$user_arr['build_time']],
            ['label'=>'備註','value'=>$user_arr['remark']]
        ]
    ]) ?>
</div>
<?php

// Above
	$items = [
		[
			'label'=>'工作內容',
			'active'=>true,
			'content'=>Yii::$app->runAction('backend/weekinfo'),
		],
		[
			'label'=>'訊息發送',
			'content'=>''
		],
	];
	echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
	]);