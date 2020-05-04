
<?php

	use app\models\UploadForm;

	$model = new UploadForm();
?>
<div id="main" class="wrapper style1">
	<section class="container">
<?php require $model->home_file.'/pages/'.$op; ?>
	</section>
</div>
