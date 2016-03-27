<?php
namespace backend\controllers\system;

use Yii;
use yii\helpers\Url;
use app\components\BrbacController;
use app\models\Admin;

/**
 * Admin controller
 */
class AdminController extends BrbacController
{
    public $layout = 'main';
    public $layout_data = [];
    
    /**
    * 列表
    */  
    public function actionIndex()
    {
        $act = Yii::$app->request->get('act');
        if($act == 'load')
        {
            $model = new Admin();
            $query = $model->db;
            $list  = $model->get_AjaxPage($query,['order'=>'aid']);
            exit(json_encode($list));
        }
        return $this->render('index');
    }

    /**
    * 添加
    */  
    public function actionCreate()
    {
        $act   = Yii::$app->request->post('act');
        $result= $this->outResult();
        $model = new Admin();
        $model->setScenario('create');
        if($act == 'save')
        {
            $params = Yii::$app->request->post();
            if($model->load($params))
            {
                $ret                = $model->insert();
                $result['success']  = true;
                $result['msg']      = Yii::t('backend_html', 'Successful operation');
            }
            exit(json_encode($result));
        }
        else
        {
            $model->status = 1;
            $content  = $this->renderPartial('create',['model' => $model]);
            return $this->renderAjax('@app/views/layouts/main_dialog',['content' => $content,'htitle'=>Yii::t('form_label', 'create')]);
        }
        return $this->render('create');
    }

    /**
    * 修改
    */  
    public function actionUpdate()
    {
        $result= $this->outResult();
        $act   = Yii::$app->request->post('act');
        $id    = intval(Yii::$app->request->post('id'));
        $model = new Admin();
        $row   = $model->getCache_Admin($id);
        if(!$row)exit(json_encode($result));
        $model->setOldAttributes($row);
        $model->setAttributes($row,false);
        $model->setScenario('update');
        if($act == 'save')
        {
            $params = Yii::$app->request->post();
            unset($params['Admin']['reg_time']);
            if($model->load($params))
            {
                $ret                = $model->update();
                $result['success']  = true;
                $result['msg']      = Yii::t('backend_html', 'Successful operation');
            }
            exit(json_encode($result));
        }
        else
        {
            $model->password     = $model->initPwd;
            $model->password_rep = $model->initPwd;
            $content = $this->renderPartial('update',['model' => $model]);
            return $this->renderAjax('@app/views/layouts/main_dialog',['content' => $content,'htitle'=>Yii::t('form_label', 'create')]);
        }
        return $this->render('update');
    }

    /**
    * 删除
    */  
    public function actionDelete()
    {
        $result= $this->outResult();
        $ids   = Yii::$app->request->post('id');
        if($ids)
        {
            $model = new Admin();
            $ret   = $model->_delete($ids);
            if($ret)
            {
                $result['success']  = true;
                $result['msg']      = Yii::t('backend_html', 'Successful operation');
            }
            else
            {
                $result['msg']      = Yii::t('backend_html', 'operation failed');
            }    
        }
        exit(json_encode($result));
    }
}
