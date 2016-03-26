<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace libs\base;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [];
    public $js       = [];
    public $depends  = [
                        'yii\web\YiiAsset',
                        'yii\bootstrap\BootstrapPluginAsset',
                        'yii\widgets\ActiveFormAsset'
                        ];

    public function init()
    {
        parent::init();
        $this->basePath = '@static';
        $this->baseUrl  = staticDir;
    }

    //定义按需加载JS方法，注意加载顺序在最后  
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [BAsset::className(), 'depends' => ['libs\base\BAsset']]);  
    }  
      
   //定义按需加载css方法，注意加载顺序在最后  
    public static function addCss($view, $cssfile)
    {  
        $view->registerCssFile($cssfile, [BAsset::className(), 'depends' => 'libs\base\BAsset']);  
    }

    //加载原生态组件
    /*public static function loadAsset($Asset='yii\bootstrap\BootstrapAsset',$css=['css/bootstrap.min.css'],$js=['js/bootstrap.min.js'])
    {
        $temp = [];
        if($css)$temp['css'] = $css;
        if($js)$temp['js']   = $js;
        if($Asset && $temp)
        {
            \Yii::$app->assetManager->bundles[$Asset] = $temp;
        }
    }*/
}
