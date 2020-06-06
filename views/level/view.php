<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Level */

$this->title = $model->job_name;
$this->params['breadcrumbs'][] = ['label' => '職權', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="level-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('停用', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '確定要刪除此職稱嗎?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<?php
		function LevelRight($data){
			$decbin = preg_split('//', decbin($data), -1, PREG_SPLIT_NO_EMPTY);
			$text = [];
			if(!empty($decbin[0]) && $decbin[0] == 1){
				$text[] = '<span style="color:#337ab7" class="glyphicon glyphicon-eye-open"></span> ';
			}
			if(!empty($decbin[0]) && $decbin[1] == 1){
				$text[] = '<span style="color:#337ab7" class="glyphicon glyphicon-plus"></span> ';
			}
			if(!empty($decbin[0]) && $decbin[2] == 1){
				$text[] = '<span style="color:#337ab7" class="glyphicon glyphicon-pencil"></span> ';
			}
			if(!empty($decbin[0]) && $decbin[3] == 1){
				$text[] = '<span style="color:#337ab7" class="glyphicon glyphicon-trash"></span> ';
			}
			return implode('、',$text);
		}
		$level_right = DetailView::widget([
			'model' => $model,
			'attributes' => [
				['label'=>'交件權限','format' => 'html','value'=>LevelRight($model['today_case'])],
				['label'=>'病例權限','format' => 'html','value'=>LevelRight($model['toothcase'])],
				['label'=>'支出權限','format' => 'html','value'=>LevelRight($model['outlay'])],
				['label'=>'報表權限','format' => 'html','value'=>LevelRight($model['report'])],
				['label'=>'員工權限','format' => 'html','value'=>LevelRight($model['admin_sheet'])],
				['label'=>'材料權限','format' => 'html','value'=>LevelRight($model['material'])],
				['label'=>'診所權限','format' => 'html','value'=>LevelRight($model['clinic'])],
				['label'=>'職位權限','format' => 'html','value'=>LevelRight($model['level'])],
				['label'=>'前台權限','format' => 'html','value'=>LevelRight($model['frontend'])],
			],
		]);
	?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'job_name',
            'build_time',
			['label'=>'建立人','value'=>$model['adminSheets'][0]['user_name']],
			['label'=>'職權','format' => 'html','value'=>$level_right]
        ],
    ]) ?>

</div>
