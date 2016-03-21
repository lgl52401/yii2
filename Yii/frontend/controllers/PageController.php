<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\components\BaseFrontController;

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
