<?php
namespace backend\controllers\system;

use Yii;
use yii\helpers\Url;
use app\components\BrbacController;
use app\models\Admin;

/**
 * Main controller
 */
class AdminController extends BrbacController
{
    public $layout = 'main';
    public $layout_data = [];
    
    /**
    * 列表视图
    *
    */  
    public function actionIndex()
    {
        $act = Yii::$app->request->get('act');
        if($act == 'load')
        {
            $model = new Admin();
            $query = $model->db->from($model::tableName());
            $list  = $model->get_AjaxPage($query);
            exit(json_encode($list));
        }
        return $this->render('index');
    }
}
