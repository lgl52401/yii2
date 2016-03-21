<?php
namespace app\components;
use Yii;
use libs\base\BController;

class BaseFrontController extends BController
{
	public function init()
	{
		parent::init();
		//\Yii::$app->language = 'zh-CN';
	}
}