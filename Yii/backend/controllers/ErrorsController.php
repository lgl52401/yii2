<?php
namespace backend\controllers;

use Yii;
use app\components\BaseController;

/**
 * Errors controller
 */
class ErrorsController extends BaseController
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
