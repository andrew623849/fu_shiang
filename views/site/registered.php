<?php
	use yii\helpers\Html;use yii\widgets\ActiveForm;
?>
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
				<h2 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">註冊資料</h2>
				<?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'user_admin')->textInput(['maxlength' => true]) ?>
				<div class="form-group">
					<label class="control-label" for="userlist-password"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">密碼</font></font></label>
					<input type="password" id="userlist-password" class="form-control" name="UserList[password]" maxlength="64">
					<div class="help-block"></div>
				</div>
				<?= Html::submitButton('送出', ['class' => 'btn btn-success']) ?>

			</div>
			<div class="col-md-6">
				<h2 style="margin: 30px 0;padding-bottom: 5px;border-bottom: 1px solid #e7ecf1;">費用說明</h2>
				<h5>目前為開發階段，故無收費方式，預告明年開始收費。</h5>
				<h5>可在群組內詢問操作或是提出需求，打造最適合您的系統</h5>
				<a href="https://lin.ee/1TtVk9sQ1"><img height="36" border="0" src="https://scdn.line-apps.com/n/line_add_friends/btn/zh-Hant.png"></a>

			</div>
			<?php ActiveForm::end(); ?>
		</section>
	</div>
</div>
