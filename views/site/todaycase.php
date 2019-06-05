<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $date.'~'.$date7.'要送的CASE';
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php for($i = 0;$i < count($model);$i ++){ 
    $models = $model[$i];
    if($models['end_time'] <= date('Y-m-d',strtotime('+3 day'))){
        $options= "border:3px red solid";
    }else{
        $options = "";
    }
    ?>
    <div class="col-sm-4">
    <?php echo DetailView::widget([
        'model' => $models,
        'attributes' => [
            ['label'=>'診所','value'=>$clinic_info[($models->clinic_id-1)]['clinic']],
            ['label'=>'收件日','value'=>$models->start_time],
            ['label'=>'交件日','value'=>$models->end_time],
            ['label'=>'病人姓名','value'=>$models->name],
            ['label'=>'材料','value'=>$material_info[($models->material_id)-1]['material']],
            ['label'=>'齒位','value'=>$models->tooth],
            ['label'=>'齒色','value'=>$models->tooth_color],
            ['label'=>'備註','value'=>$models->remark],
            ['label'=>'金額','value'=>$models->price],
        ],
        'options'=>['class' => 'table table-striped table-bordered detail-view','style'=>$options],
    ]) ?>
    </div>
<?php }?>

