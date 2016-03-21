<?php
namespace frontend\controllers;

use Yii;
use app\models\Route;
use app\components\BaseFrontController;
use yii\web\UploadedFile;

class HomeController extends BaseFrontController
{
    public function actions()
    {
        return [
            'Kupload' => [
                'class' => 'pjkui\kindeditor\KindEditorAction',
            ]
        ];
    }

    public function actionIndex()
    {
          
    	//$follow= Route::find()->all();
    	$Route = new Route;
        $s = $Route->get_defaultPage($Route->db->from($Route::tableName()),['pageSize'=>3]);
    	//$s = $Route->db->from($Route::tableName())->all();
    	//$s = Route::find()->joinWith('orders')->where([Route::tableName().'.route_id' => '1'])->all();
    	//$s = $a->get_row();
    	 //print_r($s);die;
    	//print_r(Route::find()->where(['route_id'=>22220])->asArray()->count());die;
    	//print_r(Route->db->from('{{%route}}')->all());die;
        return $this->render('index', $s);
    }

    public function actionCreate()
    {
        $model = new Route();
        $data = Yii::$app->request->post();
        if ($model->load($data))
        {print_r($_FILES);
            print_r($data);die;
            $model->insert(); 
            return $this->redirect(['create']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $model = new Route();
        $data = Yii::$app->request->post();
        if($data )
        {   
            print_r($_FILES);
            print_r($data);die;
            $row = $model->getCache_Route($data['route_id']);

            $model->setOldAttributes($row);
            $model->setAttributes($row,false);
            if ($model->load($data))
            {
                $model->update();
                return $this->redirect(['update']);
            }
        }

        $row = $model->getCache_Route(312);
   
           
        //print_r($row );die;
        $model->setAttributes($row,false);
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete()
    {
        $ids = Yii::$app->getRequest()->getQueryParam('ids');
        if($ids)
        {
            $model = new Route();
            $model->_delete($ids);
        }
    }

    public function actionCache($value='')
    {
        $model = new Route();
        Yii::$app->db->schema->refresh($model->tableName());
        //Yii::$app->db->schema->refreshTableSchema($model->tableName());
        exit('aa');
        //Yii::$app->db->schema->refreshTableSchema($tableName);

    }



}
