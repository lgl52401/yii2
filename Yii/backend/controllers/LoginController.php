<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use app\components\BaseController;
use app\models\Admin;

/**
 * Login controller
 */
class LoginController extends BaseController
{
    public $layout = 'main_login';
    public $layout_data = ['cls'=>'login-content'];

    public function actions()
    {
        return [
            'captcha' => Yii::$app->params['captcha']
        ];
    }

    public function actionIndex()
    {
        /*if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }*/
        $model = new Admin();
        $model->scenario = 'index';
        $data = Yii::$app->request->post();
        if ($model->load($data) && $model->validate())
        {
           exit(json_encode([]));
            die;
            return $this->goBack();
        } 
        else 
        {//exit(json_encode([]));
            return $this->render('index', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
