<?php
namespace app\components;
use Yii;
use app\components\BaseController;
use yii\helpers\Url;
use app\models\Admin;

/**
 * 已经登录继承基类
 */
class BloginController extends BaseController
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

    /**
    * 后台用户登录
    *
    */  
    public function checkLogin()
    {
        $this->beforeExt();
        $this->auto_lang();
        $model = new Admin();
        if(!$model->checkLogin())
        {
            if (Yii::$app->request->isAjax)
            {
                $result = $this->outResult(Yii::t('backend_html', 'Not logged in or login timeout'));
                exit(json_encode($result));
            }
            return $this->redirect(Url::to(['login/'],true));
        }
    }
}