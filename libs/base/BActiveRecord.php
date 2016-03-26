<?php
namespace libs\base;
use Yii;
use yii\db\ActiveRecord;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\helpers\HtmlPurifier;
use yii\web\NotFoundHttpException;

/**
 * BActiveRecord
 */
class BActiveRecord extends ActiveRecord
{
	public $db;
	public function init()
	{
		parent::init();
		$this->db = new \yii\db\Query();
	}

	/*
		统一输出结果
	*/
	public function outResult($msg = '')
	{
		$msg    = $msg ? $msg : Yii::t('model', 'verification failed');
		$result = ['success'=>false,'msg'=>$msg,'data'=>'','ids'=>''];
		return $result;
	}

	/*
		Ajax 请求是使用
	*/
	public function get_AjaxPage($query, $config = [])
	{
		$configs  = ['start'=>0,'pageSize'=>30,'order'=>''];
		$config  += $configs;
		$rows 	= [];
		$param    = json_decode(Yii::$app->request->post('pageparam'),true);
		$draw  	= isset($param[0]['value']) ? $param[0]['value'] : 1;
		$draw  	= max(1,intval($draw));
		$pageSize = isset($param[4]['value']) ? $param[4]['value'] : $configs['pageSize'];
		$pageSize = min(500,intval($pageSize));
		$start    = isset($param[3]['value']) ? $param[3]['value'] : $configs['start'];
		$start    = max(0,intval($start));
		$page     = floor($start / $pageSize) + 1;
		
		$start 	= ($page-1) * $pageSize;
		$limit 	= $pageSize;
		$number   = $query->count();
		if($number > 0)
		{
			$rows = $query->offset($start)->limit($limit);
			if(!empty($config['order']))
			{
				$rows = $rows->orderBy($config['order']);
			}
	        	$rows = $rows->all();
		}
		$data = [
				'draw'			=>$draw,
				'recordsFiltered'	=>$number,
				'recordsTotal'	 	=>$number,
				'data'			=>$rows
				];
		return $data;
	}

    /*
		读取翻页数据库记录
		asArray: 返回数组或者对象
		page : 当前页码
		pageSize：设置每页的大小
		order：数据的排序
		rows：返回的数组中数据对象的键名
		pages：返回的数组中分页对象的键名
	*/
    public function get_defaultPage($query, $config = [])
	{
		$configs = ['asArray'=>true,'page'=>0,'pageSize'=>50,'order'=>'','rowsLable'=>'rows','pagesLable'=>'pages'];
		$config  += $configs;
		if (empty($config['page']))
		{
			$config['page'] = Yii::$app->getRequest()->getQueryParam('page');
		}
		else
		{
			$_GET['page'] = intval($config['page']);
		}	
		$ret 		= [];
		$rows 		= [];
		$pageSize  	= max(1,intval($config['pageSize']));
		//$countQuery = clone $query;
        $pages 		= new Pagination(['totalCount' => $query->count()]);
        $pages->setPageSize($pageSize,true);
        $pages->defaultPageSize = $pageSize;
        if($pages->totalCount > 0)
        {
        	$rows = $query->offset($pages->offset)->limit($pages->limit);
	        if(!empty($config['order']))
	        {
	            $rows = $rows->orderBy($config['order']);
	        }
	        if($config['asArray'] && method_exists($rows,'asArray'))
	        {
	        	$rows->asArray();
	        }
	        $rows = $rows->all();
        }
        $ret[$config['rowsLable']] 	= $rows;
        $ret[$config['pagesLable']] = $pages;
        return $ret;
	}

	/*
		同上
	*/
     public function get_fetchPage($query, $config = [])
	{
		$configs  = ['page'=>0,'pageSize'=>50,'order'=>'','rowsLable'=>'rows','pagesLable'=>'pages'];
		$config  += $configs;
		if (empty($config['page']))
		{
			$config['page'] = Yii::$app->getRequest()->getQueryParam('page');
		}
		
		$ret 		= [];
		$rows 		= [];
		$page  		= max(1,intval($config['page']));
		$pageSize  	= max(1,intval($config['pageSize']));
		$start 		= 0;
		$number 	= $query->count();
		$pagenum	= ceil($number/$pageSize);
        $page 		= min($page,$pagenum);
		if($number > 0)
		{
			$start = ($page-1) * $pageSize;
			$rows  = $query->offset($start)->limit($pageSize);
	        if(!empty($config['order']))
	        {
	            $rows = $rows->orderBy($config['order']);
	        }
	        $rows = $rows->all();
		}
        $ret[$config['rowsLable']] 	= $rows;
        $ret[$config['pagesLable']] = [
			        				'page'		=>$page,
			        				'total'		=>$number,
			        				'pageSize'	=>$pageSize,
			        				'pagenum'	=>$pagenum,
			        				'prepg'		=>max(1,$page-1),
			        				'nextpg'	=>min($page+1,$pagenum)
			        				];
        return $ret;
	}

	/*
		默认配置
	*/
	protected function default_page()
	{
		$datainfo   				= array();
		$pageparam 				= Yii::$app->request->post('pageparam');
		$pageparam 				= is_array($pageparam) ? json_encode($pageparam) : array();
		$datainfo['draw']   		= isset($pageparam[0]['value'])  ? max(1,intval($pageparam[0]['value'])) : '0';
		$datainfo['recordsFiltered'] 	= 0;
		$datainfo['recordsTotal']    	= 0;
		$datainfo['data']   	 	= array();
		return $datainfo;
	}

	/**
	 * model层的数据过滤
	 */
	public function filterData($data = array())
	{
		$list = $this->getAttributes();
		foreach ($data as $key => $val)
		{
			if($key == 'integer')
			{
				foreach ($val as $key_s => $val_s)
				{
					$this->$val_s = intval($list[$val_s]);
					unset($list[$val_s]);
				}
			}
			elseif($key == 'html')
			{
				foreach ($val as $key_s => $val_s)
				{
					$temp = HtmlPurifier::process($list[$val_s],$this->HTML_config());
					$this->$val_s = $temp;
					unset($list[$val_s]);
				}
			}
			elseif($key == 'float1')
			{
				foreach ($val as $key_s => $val_s)
				{
					$this->$val_s = sprintf('%.1f',$list[$val_s]);
					unset($list[$val_s]);
				}
			}
			elseif($key == 'float')
			{
				foreach ($val as $key_s => $val_s)
				{
					$this->$val_s = sprintf('%.2f',$list[$val_s]);
					unset($list[$val_s]);
				}
			}
		}
		foreach ($list as $key => $val)
		{
			$this->$key = strip_tags($val);
		}
		//$list = $this->getAttributes();
	}

	public function beforeValidate()
	{
		if(parent::beforeValidate())
		{
			return true;
		}
		return false;
	}

	public function afterValidate()
	{
		$errors = $this->getErrors();
		if(!empty($errors))
		{
			$dump = VarDumper::dumpAsString($this);
			Yii::info($dump, '_form');
			if(Yii::$app->request->isAjax)
			{
				$ret = $this->outResult();
				$ret['msg'] .= '</br><span>';
				foreach ($errors as $key => $val)
				{
					$ret['msg'] .= $val[0].'</br>';
				}
				$ret['msg'] .= '</span>';
				exit(json_encode($ret));
			}
			return false;
			//throw new NotFoundHttpException(json_encode($errors));
		}
		return true;
	}

	protected function HTML_config($type = 1)
	{
		$config = [];
		if($type == 1)
		{
			$config = [
					'HTML.SafeIframe'		=>true,
					'URI.SafeIframeRegexp'	=>'%^(https?:)?//(.)%',
					'HTML.TargetBlank'		=>true,
					'Attr.EnableID'			=>false,
					'Attr.AllowedClasses'	=>array(''),
					'AutoFormat.AutoParagraph'=>true,
					'AutoFormat.RemoveEmpty' =>true,
					'HTML.SafeObject'		 =>true,
					'HTML.SafeEmbed'		 =>true,
					'Output.FlashCompat'	 =>true
					];		
		}
		return $config;
	}
}