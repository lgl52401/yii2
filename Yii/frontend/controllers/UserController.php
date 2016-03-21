<?php
namespace frontend\controllers;

use Yii;
use app\models\User;
use app\components\BaseFrontController;

class UserController extends BaseFrontController
{
        //登录
    public function actionIndex(){
        
        $model = new User();
         //$model->scenario = 'index';
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            exit('bbb');
            return $this->goBack();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
    //注册
    public function actionRegister(){
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            exit('ss');
            if ($user = $model->register()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
