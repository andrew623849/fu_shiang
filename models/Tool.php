<?php

namespace app\models;


class Tool
{

	function MaterialMsg($u_id,$make_p,$material_id)
	{
		$material_msg = '';
		foreach($make_p as $mkey => $mval){
			if($mval == $u_id){
				$material_msg .= (!empty($material_msg)?'－＞':'').$material_id[$mkey];
			}else{
				if(!empty($material_msg))
					break;
			}
		}
		return $material_msg;
	}

	function MaterialMsgByWeek($make_p,$material_id,$make_p_f)
	{
		$material_msg = '';
		$now = self::WhoNeedLine($make_p,$make_p_f);
		foreach($make_p as $mkey => $mval){
			if($mval == $now){
				$material_msg .= (!empty($material_msg)?'－＞':'').'<span style="color:red">'.$material_id[$mkey].'</span>';
			}else{
				$material_msg .= (!empty($material_msg)?'－＞':'').$material_id[$mkey];
			}
		}
		return $material_msg;
	}

	function WhoNeedLine($make_p,$make_p_f)
	{
		foreach($make_p_f as $mkey => $mval){
			if($mval == 0) return $make_p[$mkey];
		}
	}

}
