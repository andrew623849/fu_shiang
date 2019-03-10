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