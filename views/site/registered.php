<?php
	use kartik\label\LabelInPlace;
	use yii\helpers\Html;use yii\widgets\ActiveForm;
?>
<div id="main" class="wrapper style1">
	<div class="container">
		<section>
			<div class="col-md-6">
				<?php
				$form = ActiveForm::begin([
					'action' => ['register'],
					'method' => 'post',
					'options'=>['autocomplete'=>'off']

				]); ?>
					<h3 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">註冊資料</h3>
					<?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'user_admin')->textInput(['maxlength' => true]) ?>
					<div class="form-group">
						<label class="control-label" for="userlist-password"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">密碼</font></font></label>
						<input type="password" id="userlist-password" class="form-control" name="UserList[password]" maxlength="64">

						<div class="help-block"></div>
					</div>
					<?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="col-md-6">

			</div>
		</section>
	</div>
</div>
