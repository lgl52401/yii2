<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use app\components\BloginController;
use app\models\Admin;

/**
 * Main controller
 */
class MainController extends BloginController
{
    public $layout      = 'main_login';
    public $layout_data = ['cls'=>'index-content'];

    /**
    * 后台用户主界面
    *
    */  
    public function actionIndex()
    {
        /*$this->getView()->title = 'LGL';
        $this->getView()->metaTags['keywords'] = '';
        $this->getView()->metaTags['description'] = '';*/
        return $this->render('index',['langList'=>Yii::$app->params['lang_backend']]);
    }

    /**
    * 后台用户退出
    *
    */
    public function actionAccount()
    {
        $this->layout = 'main_dialog';
        $result = $this->outResult();
        $model  = new Admin();
        $data   = Yii::$app->request->post();
        $aid    = Yii::$app->session['aid'];
        $model  = $model::find()->where(['aid' => $aid])->limit(1)->one();
        if(!$model)exit(json_encode($result));
        $model->setScenario('account');
        if($data)
        {
            $oldPassword = $model->encryptPwd($data['Admin']['password_old'],$model->reg_time);
            if($oldPassword != $model->password)
            {
                $result['msg'] = Yii::t('form_label', 'Password old').Yii::t('backend_html', 'Error');
            }
            else
            {
                $params['Admin']['password'] = $data['Admin']['password'];
                if($model->load($params))
                {   
                    $newPassword        = $model->encryptPwd($params['Admin']['password'],$model->reg_time);
                    $model->password    = $newPassword;
                    $model->password_rep= $newPassword;//确认密码赋值
                    $model->password_old= $newPassword;//旧密码赋值
                    $ret                = $model->update();
                    $result['success']  = true;
                    $result['msg']      = Yii::t('backend_html', 'Successful operation');
                }
                else
                {
                    $result['msg'] = Yii::t('backend_html', 'operation failed');
                }    
            }
            exit(json_encode($result));
        } 
        else
        {
            unset($model->password);
            $content  = $this->renderPartial('_form_account',['model' => $model]);
            return $this->renderAjax('../layouts/main_dialog',['content' => $content]);
        }
    }
}
