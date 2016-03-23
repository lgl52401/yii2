<?php
namespace app\components;
use Yii;
use libs\base\BController;

class BaseController extends BController
{
	public function init()
	{
		parent::init();
		//\Yii::$app->language = 'zh-CN';
	}

	/**
    * 在action之前运行，可用来过滤输入
    * 在具体的动作执行之前会先执行beforeAction，如果返回false,则动作将不会被执行，
    * 后面的afterAction也不会执行（但父模块跌afterAction会执行）
    */
    public function beforeAction($action)
    {
    	$this->beforeExt();
    	$cookies 	  = Yii::$app->request->cookies;
    	$scookies 	  = Yii::$app->response->cookies;
    	$lang_support = Yii::$app->params['lang_backend'];
    	$lang_default = Yii::$app->params['lang_default'];
    	$lang_now 	  = '';
        $lang         = Yii::$app->request->get('s_lang');
        $cookie_name  = 's_lang';
        $exprie       = 2592000;//一个月
        if($lang && isset($lang_support[$lang]))
        {
        	$scookies->add(new \yii\web\Cookie([
					    'name'  =>$cookie_name,
					    'value' =>$lang
						]));
        	$lang_now = $lang;
        }
        else
        {
        	$lang_now = $cookies->get($cookie_name);
        	if(!$lang_now || !isset($lang_support[$lang_now->value]))
        	{
        		$scookies->add(new \yii\web\Cookie([
						    'name'  =>$cookie_name,
						    'value' =>$lang_default
						]));
        		$lang_now = $lang_default;
        	}
        }
        \Yii::$app->language = $lang_now;
        return true;//如果返回值为false,则action不会运行
    }
}