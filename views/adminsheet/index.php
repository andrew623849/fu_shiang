<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Level;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminsheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '員工';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-sheet-index">

    <h1>在籍員工</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增員工', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'admin',
            // 'password',
            // 'build_time',
           [
            'attribute'=>'job',
            'value'=>'level.job_name',
            'label'=>'職稱',
            'filter' => ArrayHelper::map(Level::find()->Asarray()->all(),'id','job_name'),
             ],
            'user_name',
             [
                'attribute'=>'user_sale',
                'value'=>function($data){
                    return $data->user_sale == 0 ? '男' : '女';
                }
            ],
            'user_phone',
            'user_email:email',
            // 'user_pay',
            // 'user_f_na',
            // 'user_f_ph',
            // 'user_exp',
            // 'user_grade',
            // 'remark',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<div class="admin-sheet-index">

    <h1>離籍員工</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider_l,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'admin',
            // 'password',
            // 'build_time',
           [
            'attribute'=>'job',
            'value'=>'level.job_name',
            'label'=>'職稱',
            'filter' => ArrayHelper::map(level::find()->where(['<>','id',0])->Asarray()->all(),'id','job_name'),
             ],
            'user_name',
            'user_sale',
            'user_phone',
            'user_email:email',
            // 'user_pay',
            // 'user_f_na',
            // 'user_f_ph',
            // 'user_exp',
            // 'user_grade',
            // 'remark',
        ],
    ]); ?>
</div>
