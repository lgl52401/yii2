<?php
namespace app\components;
use Yii;
use app\components\BloginController;
use yii\helpers\Url;
use app\models\Admin;

class BrbacController extends BloginController
{
	public function init()
	{
		parent::init();
	}

    public function beforeAction($action)
    {
        $this->checkLogin();
        return true;
    }
}