<?php
namespace frontend\controllers;

use Yii;
use frontend\components\BaseFrontController;
use libs\base\BCaptchaAction;

/**
 * Tool controller
 */
class ToolController extends BaseFrontController
{
	public function actions()
    {
        return [
            'captcha' => Yii::$app->params['captcha']
        ];
    }
    
    public function init()
    {
        
    }
}
