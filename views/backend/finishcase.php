<?php

	use app\models\toothcaseSearch;

	$data = toothcaseSearch::getData($_POST['id'])[0];
	$user_arr = Yii::$app->session['user'];

	$make_p = explode(',',$data['make_p']);
	$make_p1 = explode(',',$data['make_p1']);
	$make_p2 = explode(',',$data['make_p2']);
	$make_p_f = [];
	foreach($make_p as $val){
		if($val == $user_arr['id']){
			$make_p_f[] = 1;
		}else{
			$make_p_f[] = 0;
		}
	}
	$make_p1_f = [];
	foreach($make_p1 as $val){
		if($val == $user_arr['id']){
			$make_p1_f[] = 1;
		}else{
			$make_p1_f[] = 0;
		}
	}
	$make_p2_f = [];
	foreach($make_p2 as $val){
		if($val == $user_arr['id']){
			$make_p2_f[] = 1;
		}else{
			$make_p2_f[] = 0;
		}
	}
	$sql = [];
	if(!empty($make_p_f)){
		$sql['make_p_f'] = implode(',',$make_p_f);
	}
	if(!empty($make_p1_f)){
		$sql['make_p1_f'] = implode(',',$make_p1_f);
	}
	if(!empty($make_p2_f)){
		$sql['make_p2_f'] = implode(',',$make_p2_f);
	}
	if(toothcaseSearch::updateAll($sql,['id'=>$_POST['id']])){
		echo '1';
	}else{
		echo '0';
	}
