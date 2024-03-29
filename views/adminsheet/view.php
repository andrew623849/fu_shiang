<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminSheet */

$this->title = $model->user_name;
$this->params['breadcrumbs'][] = ['label' => '員工', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="admin-sheet-view">

    <h1><?= Html::encode($this->title.($model->deleted==0?'(在職)':'(離職)')) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('刪除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你確定要將此員工離職嗎?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'build_time',
            ['label'=>'職稱','value'=>show_level($model['job'])],
            'user_phone',
            'user_email:email',
            'user_pay',
            'user_f_na',
            'user_f_ph',
            'user_exp',
            'user_grade',
            'remark',
        ],
    ]) ?>

</div>
