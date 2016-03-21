<?php
use yii\helpers\url;
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
批量图片格式化
*/
function images_all($data = '')
{
	$arr = [];
	if(empty($data))return $arr;
	$data = explode('|', $data);
	foreach ($data as $key => $val)
	{
		$arr['files'][] = [
				       'name'         =>basename($val),
				       'size'         =>'',
				       'url'          =>getImg($val,''),
				       'thumbnailUrl' =>getImg($val,'220_220'),
				       'deleteUrl'    =>Url::to(['tool/imagedelete','imagesPath'=>$val],true),
				       'deleteType'   =>'POST'
				       ];
	}
	return $arr;
}

/*
	获取图片
	1-图片地址
	2-图片规格
*/
function getImg($url,$size='120_120',$http=1)
{
	$arr = getConfig();
	if(strpos($url, '.')===false || strpos($url, 'http://')!==false)return $url;
	if(!isset($arr['img_size'][$size]))
	{
		return $arr['img_cdn'][0].'/' . $url;	
	}
	$path   	= dirname($url);
	$info 	= basename($url);
	$row 	= explode(".",$info);
	$length 	= count($row);
	$filename = '';
	$size 	= '_'.$size;
	if($length <= 2)
	{
		$filename = $path.'/'.$row[0].$size.'.'.strtolower($row[1]);
	}
	else
	{	
		$num  =	$length-1; 
		$type = strtolower($row[$num]);
		unset($row[$num]);
		$name = implode('.',$row);
		$filename = $path.'/'.$name.$size.'.'.$type;
	}
	if($http == 1)
	{
		return $arr['img_cdn'][0].'/'.$filename;
	}
	else
	{
		return $filename;
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