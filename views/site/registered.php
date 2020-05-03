<?php
	use yii\helpers\Html;use yii\widgets\ActiveForm;
?>
<style>
	p{
		margin: 15px 0;
	}
</style>
<div id="main" class="wrapper style1">
	<div class="container">
		<section>
			<?php
				$form = ActiveForm::begin([
					'action' => ['register'],
					'method' => 'post',
					'options'=>['autocomplete'=>'off']

				]); ?>
			<div class="col-md-6">
				<h1 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">註冊資料</h1>
				<?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'user_admin')->textInput(['maxlength' => true]) ?>
				<div class="form-group">
					<label class="control-label" for="userlist-password"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">密碼</font></font></label>
					<input type="password" id="userlist-password" class="form-control" name="UserList[password]" maxlength="64">
					<div class="help-block"></div>
				</div>
			</div>
			<div class="col-md-6">
				<h1 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">費用說明</h1>
				<p>目前為開發階段，故無收費方式，預告明年開始收費</p>
				<p>可加入下方Line，提出需求，做出最符合您的管理系統</p>
				<?= Html::img('../images/Line.jpg') ?>
				<?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>

			</div>
			<?php ActiveForm::end(); ?>
		</section>
	</div>
</div>
