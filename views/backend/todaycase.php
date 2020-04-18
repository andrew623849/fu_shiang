<?php

	use edofre\fullcalendar\Fullcalendar;
	use kartik\dialog\Dialog;
	use yii\helpers\Url;
	use yii\web\JsExpression;
	echo Dialog::widget([
		'libName' => 'krajeeDialog',
		'options' => [
			'title' => '事件內容',
			'size' => Dialog::SIZE_LARGE, // large dialog text
			'type' => Dialog::TYPE_SUCCESS, // bootstrap contextual color
			'draggable' => true,
			'closable' => true
		],
	]);
	echo Fullcalendar::widget([
	'options'       => [
		'id'       => 'calendar',
		'language' => 'zh-tw',
	],
	'clientOptions' => [
		'defaultView' => 'agendaDay',
		'eventLimit'=>5,
		'aspectRatio'=>'auto',
		'minTime'=>'07:00',
		'maxTime'=>'22:00',
		'firstDay'=>'1',
		'nowIndicator'=>true,
		'selectable'=>true,
		'eventClick'=>new JsExpression('
			function(info){
				$.ajax({
					url: "/backend/edetail",
					type:"POST",
					cache: false,
					data: {
						id:info.className[0]
					}
				}).done(function(data){
					data = data.replace(/\r\n|\n/g,"");
					krajeeDialog.alert(data);
				});
			}
		'),

	],
	'events'=> Url::to(['/backend/event']),
]);
?>
