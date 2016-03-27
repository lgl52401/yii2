<?php
namespace app\components;
use Yii;
use app\components\BloginController;
use yii\helpers\Url;
use app\models\Admin;

/**
 * 登陆后-权限继承基类
 */
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