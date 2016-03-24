<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\components\BaseController;
use app\models\Admin;

/**
 * Login controller
 */
class LoginController extends BaseController
{
    public $layout      = 'main_login';
    public $layout_data = ['cls'=>'login-content'];

    /**
    * 后台用户登录
    *
    */  
    public function actionIndex()
    {
        $model = new Admin();
        if($model->checkLogin())
        {
            return $this->redirect(Url::to(['main/'],true));
        }
        
        $model->scenario = 'index';
        $data = Yii::$app->request->post();
        if($model->load($data))
        {
            $result = $model->login();
            exit(json_encode($result));
        } 
        else 
        {
            return $this->render('index', ['model' => $model]);
        }
    }

    /**
    * 后台用户退出
    *
    */
    public function actionLogout()
    {
        $model = new Admin();
        $model->logout();
        return $this->redirect(Url::to(['/login'],true));
    }
}
