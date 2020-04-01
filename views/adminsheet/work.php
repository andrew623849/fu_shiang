<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Level;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminsheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="admin-sheet-index">

    <h1>在職員工</h1>
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
            ['class' => 'yii\grid\ActionColumn',
             'header' => '操作',
             'template' =>'{view} {update} {delete}',
             'buttons' => [
                'delete'=>function ($url, $model, $key) {
                    if($model->job <= Yii::$app->session['user']['job']){
                        return '';
                    }else{
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['leave', 'id' => $model->id], ['data'=>['confirm'=>'你確定要將此員工離職嗎?']]);
                    }
                },
                'update'=>function ($url, $model, $key) {
                    if($model->job <= Yii::$app->session['user']['job']){
                        return '';
                    }else{
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id]);
                    }
                },
                'view'=>function ($url, $model, $key) {
                    if($model->job <= Yii::$app->session['user']['job']){
                        return '';
                    }else{
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id]);
                    }
                }]
            ],
        ],
    ]); ?>
</div>
