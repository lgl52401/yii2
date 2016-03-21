<?php
namespace app\components;
use Yii;
use libs\base\BController;

class BaseController extends BController
{
	public function init()
	{
		parent::init();
		//\Yii::$app->language = 'zh-CN';
	}
}