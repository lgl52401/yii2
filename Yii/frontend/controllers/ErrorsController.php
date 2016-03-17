<?php
namespace frontend\controllers;

use Yii;
use frontend\components\BaseFrontController;

/**
 * Errors controller
 */
class ErrorsController extends BaseFrontController
{
	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function init()
    {
 		parent::init();
    	if (Yii::$app->request->isAjax)
    	{
    		$result = $this->outResult();
    		exit(json_encode($result));
    	}
    }
}
