<?php
namespace libs\base;

use Yii;
use yii\web\View;
use yii\helpers\Url;

class BView extends View
{
	public function init()
	{
		parent::init();
	}

	public function nowUrl($data = [])
	{
		$data	= (array)$data;
		$url 	= Yii::$app->urlManager->parseRequest(Yii::$app->request);
		$list[0] 	= $url[0];
		$list 	= $list + $data;
		$url 	= Url::to($list,true);
		return $url;
	}
}
