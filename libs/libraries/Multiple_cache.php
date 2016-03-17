<?php
namespace libs\libraries;
use Yii;

/**
 * 批量获取缓存数据
 *	$cache_type => [FileCache,MemCache,DbCache,RedisCache];
 */
class Multiple_cache
{
	static public function set_cache($id, $obj, $parame = [], $cache_type='FileCache')
	{
		$ext = array(
					'table'			=>'',
					'cache_key'		=>'',
					'primary_key'	=>'',
					'sort'          =>array()
					);
		$ext 	  = $parame + $ext;
		$is_array = true;
		if(!$id || !$obj ||  !$ext['cache_key'] || !$ext['primary_key'])
		{
			return array();
		}
		
		if(is_array($id))
		{
			$id = to_intval($id,2);
			if(!$id)
			{
				return array();
			}
		}
		else
		{
			$id  	  = array(intval($id));
			$is_array = false;
			if($id < 1)
			{
				return array();
			}
		}

		$data = array();
		$ids  = array();
		foreach ($id as $key => $val)
	    {
	    	$cache = Yii::$app->$cache_type->get($ext['cache_key'] . $val);
	        $cache = json_decode($cache,true);
	        if(!is_array($cache))
	        {
	            $ids[] = $val;
	        }
	        else
	        {
	            $data[$val] = $cache;
	        }    
	    }

	    if($ids)
	    {
	    	$rows   = empty($ext['table']) ? $obj->db->from($obj->tableName()) : $obj->db->from($ext['table']);
	    	$rows   = $rows->where([$ext['primary_key'] => $ids]);
	        $simple = true;

	        if(isset($ext['sort']) && isset($ext['sort']['id']) && $ext['sort']['id'] && isset($ext['sort']['sort']) && $ext['sort']['sort'])
	        {
	        	$simple = false;
	        }

	        if(!$simple)
	        {
	        	$rows = $rows->orderBy($ext['sort']['id'].' '.$ext['sort']['sort']);
	        }
	        //exit($rows->createCommand()->getRawSql());
	        $cache = $rows->all();
	        if($cache)
	        {
	            $temp = array();
	            if(!$simple)
	            {
		            foreach ($cache as $key => $val)
		            {
		                $data[$val[$ext['primary_key']]][$val[$ext['sort']['id']]] = $val;
		                $temp[$val[$ext['primary_key']]] = $val[$ext['primary_key']];
		            }

		            foreach ($temp as $key => $val)
		            {
		                Yii::$app->$cache_type->set($ext['cache_key'].$val, json_encode($data[$val]), 2592000);
		            }
	            }
	            else
	            {
	            	foreach ($cache as $key => $val)
		            {
		                $data[$val[$ext['primary_key']]] = $val;
		                Yii::$app->$cache_type->set($ext['cache_key'].$val[$ext['primary_key']], json_encode($val), 2592000);
		            }
	            }	
	        }
	    }
	    
	    if($is_array)
	    {
	        return $data ? $data:array();
	    }
	    else
	    {
	        return isset($data[$id[0]]) ? $data[$id[0]] :array();
	    }
	}
}