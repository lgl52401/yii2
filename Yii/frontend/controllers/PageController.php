<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\components\BaseFrontController;

/**
 * Site controller
 */
class PageController extends BaseFrontController
{
   
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        echo $ss;
        //exit(Yii::getAlias("@web"));
       // exit(date('Y-m-d H:i:s'));
        return $this->render('index');
    }

}
