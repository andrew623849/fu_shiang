<?php

function p_r($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';

}

function v_d($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	die;
}
function show($var){
	echo $var;
	exit();
}

function OpenSVG($str){
	$mysvg = fopen("./images/svg/".$str.".svg","r") or die( "Unable to to file!");
	echo fread($mysvg,filesize("./images/svg/".$str.".svg"));
	fclose($mysvg);
}