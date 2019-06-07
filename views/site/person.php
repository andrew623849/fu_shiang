<?php
;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user_arr = Yii::$app->session['user'];
$this->title = $user_arr[3];
$job_arr =['老闆','經理','高級牙技師','初級牙技師']
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-sm-4">
    <?= DetailView::widget([
        'model'=>$user_arr,
        'attributes' => [
            ['label'=>'員工編號','value'=>$user_arr[0]],
            ['label'=>'職稱','value'=>$job_arr[$user_arr[2]]],
            ['label'=>'聯絡方式','value'=>$user_arr[4]],
            ['label'=>'緊急聯絡人','value'=>$user_arr[7]],
            ['label'=>'緊急聯絡人聯絡方式','value'=>$user_arr[8]],
            ['label'=>'信箱','value'=>$user_arr[5]],
            ['label'=>'學歷','value'=>$user_arr[10]],
            ['label'=>'經歷','value'=>$user_arr[9]],
            ['label'=>'薪資','value'=>$user_arr[6]],
            ['label'=>'到班日','value'=>$user_arr[1]],
            ['label'=>'備註','value'=>$user_arr[11]]
        ]
    ]) ?>
    </div>
    <div class="col-sm-8">
        <img>
    </div>
</div>


