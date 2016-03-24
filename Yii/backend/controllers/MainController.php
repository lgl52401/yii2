<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use app\components\AdminController;
use app\models\Admin;

/**
 * Main controller
 */
class MainController extends AdminController
{
    public $layout      = 'main_login';
    public $layout_data = ['cls'=>'index-content'];

    /**
    * 后台用户主界面
    *
    */  
    public function actionIndex()
    {
        //print_r(Yii::$app->params);die;
       /* $cookies      = Yii::$app->request->cookies;
        $cookie_lang = $cookies->getValue('sssssss','zzz');*/
        return $this->render('index',['langList'=>Yii::$app->params['lang_backend']]);
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
    public function actionAccount()
    {
        $this->layout = 'main_dialog';
        $model = new Admin();//Partial
        $content  = $this->renderPartial('account',['model' => $model]);
        return $this->renderAjax('../layouts/main_dialog',['content' => $content],'index');
    }
}
