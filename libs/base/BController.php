<?php
namespace libs\base;
use Yii;
use yii\web\Controller;

/**
 * Base controller
 */
class BController extends Controller
{
    public function init()
    {
        parent::init();
        if (!defined('SYS_TIME')) define('SYS_TIME', time());
    }

    /*
        统一输出结果
    */
    public function outResult($msg = '')
    {
        $result = ['success'=>false,'msg'=>$msg,'data'=>'','ids'=>''];
        return $result;
    }

    /**
    * 在action之前运行，可用来过滤输入
    * 在具体的动作执行之前会先执行beforeAction，如果返回false,则动作将不会被执行，
    * 后面的afterAction也不会执行（但父模块跌afterAction会执行）
    */
    public function beforeExt()
    {
        $schema = strip_tags(Yii::$app->request->get('schema'));
        if($schema)
        {
            Yii::$app->db->schema->refreshTableSchema($schema);
            exit();
        }
        return true;//如果返回值为false,则action不会运行
    }

    /**
     * 当前动作执行之后，执行afterAction
     */
    public function afterAction($action, $result)
    {
        //可以对action输出的$result进行过滤，retun的内容会直接显示
        return $result;
    }
}
