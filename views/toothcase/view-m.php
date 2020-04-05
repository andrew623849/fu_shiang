<?php

use app\models\AdminSheet;
use app\models\Material;

$material = Material::find('material')->indexBy('id')->asArray()->all();
$admin_sheet = AdminSheet::find('user_name')->indexBy('id')->asArray()->all();

$make_prog = explode(',',$material[$set]['make_process']);
$make_p = explode(',',$make_p);
$make_p_f = explode(',',$make_p_f);
?>

<style>
	.progressbar {
		counter-reset: step;
		padding-left: 0px;

	}
	.progressbar li {
		list-style-type:none;
		/*float: left;*/
		width: 200px;
		position: relative;
		text-align: right;
	}
	.progressbar li:before{
		content: counter(step);
		counter-increment: step;
		width:40px;
		height: 40px;
		line-height: 40px;
		border: 2px solid greenyellow;
		display: block;
		text-align: center;
		margin: 0px auto 10px auto;
		border-radius: 50%;
		background-color: greenyellow;
		color:#ffffff;
		font-size: 20px;

	}
	.progressbar li:after{
		content:'';
		position: absolute;
		width: 2px;
		height: 100%;
		background-color: greenyellow;
		top:-80%;
		left:50%;
		z-index: -1;
	}
	.progressbar li:first-child:after{
		content:none;
	}
	.progressbar .finish:before {
		content:'✔';
		background-color: blue;
		border: 2px solid blue;

	}
	.progressbar .finish:after {
		background-color: blue;

	}
</style>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>材料：<?= $material[$set]['material']?></label>
		</div>
		<div class="form-group">
			<label>齒色：<?= $color?></label>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>齒位：</label>
		</div>
		<?php OpenSVG("tooth_view"); ?>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>製成：</label>
		</div>
		<div>
			<ul class="progressbar">
				<?php foreach($make_prog as $key=>$val){?>
					<li <?php echo $make_p_f[$key]?'class="finish"':'';?>><?= $val.'<br>'.$admin_sheet[$make_p[$key]]['user_name'];?> </li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>

<?php
$tooth = explode(',',$tooth);
$js =<<< JS
	
JS;
foreach($tooth as $val){
	$js .= '$(".tooth'.$val.'").eq('.$id.').css({\'visibility\': \'hidden\'});';
}

$this->registerJs($js);
