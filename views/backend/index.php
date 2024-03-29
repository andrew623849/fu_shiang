<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\toothcaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="site-login">
    <?php if(isset($message) &&  $message!=""){
       echo '<div class="alert alert-danger">'.$message.'</div>';
     } ?>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => ['backend/person'],
        'method' => 'post',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
        <div class="form-group">
            <label>帳號:
            <input type = "text" name = "admin" ></label>
        </div>
        <div class="form-group">
            <label>密碼:
            <input type = "password" name = "password" ></label>
        </div>
        <div class="form-group">
            <?= Html::submitButton('登入', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
<?php ActiveForm::end(); ?>
</div>