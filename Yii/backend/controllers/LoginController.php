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
    public $layout_data = ['cls'=>'login'];

    public function actions()
    {
        return [
            'captcha' => Yii::$app->params['captcha']
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new Admin();
        $model->scenario = 'index';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('index', [
                'model' => $model,
                
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
