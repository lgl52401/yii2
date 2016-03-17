<?php
namespace frontend\components;
use Yii;
use libs\base\BController;

class BaseFrontController extends BController
{
	public function init()
	{
		parent::init();
		//\Yii::$app->language = 'zh-CN';
	}

	/*
		统一输出结果
	*/
	public function outResult()
	{
		$result = ['success'=>false,'msg'=>'','data'=>'','ids'=>''];
		return $result;
	}
}