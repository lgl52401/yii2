<?php
/*
	获取配置文件
	1-获取的数组索引名称
	2-获取文件名称
*/
function getConfig($type='',$parame='',$set = '')
{
	static $conArr = array();
	$parame = $parame ? $parame : 'settings';
	if($set)
	{
		$conArr[$parame] = $set;
		return $conArr[$parame];
	}

	if(!isset($conArr[$parame]))
	{
		$conArr[$parame] = require(GLOBALDIR.$parame.'.php');
	}
	if($type)
	{
		return $conArr[$parame][$type];
	}
	else
	{
		return $conArr[$parame];
	}	
}

/*
	对传入数据转换为整型后返回
	1-数组或者字符
*/
function to_intval($data,$type=1)
{
	$tmpdata = !is_array($data) ? explode(",", $data) : $data;
	foreach ($tmpdata AS $key=>$val)
	{
		$tmpdata[$key] = intval($val);
	}
	if($type==1)
	{
		return is_array($data) ? $tmpdata : implode(",", $tmpdata);
	}	
	elseif($type==2)//数组
	{
		return $tmpdata;
	}
	else//字符
	{
		return implode(",", $tmpdata);
	}
}