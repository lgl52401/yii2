<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\components\BaseController;
use app\models\Admin;

/**
 * Main controller
 */
class MainController extends BaseController
{
    public $layout      = 'main_login';
    public $layout_data = ['cls'=>'index-content'];

    /**
    * 后台用户主界面
    *
    */  
    public function actionIndex()
    {
        return $this->render('index');
        $model = new Admin();
        if($model->checkLogin())
        {
            return $this->redirect(Url::to(['main/index'],true));
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
