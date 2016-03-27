<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;
use libs\base\BAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends BAsset
{
    public function init()
    {
        parent::init();
        //parent::loadAsset();

        /*$temp['js'] = ['yii.validation.js','yii.activeForm.js'];
        \Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = [];*/
        $this->css      = ['plug/font-awesome/css/font-awesome.min.css','plug/wesley/wesleyPlug.css','backend/css/base.css'];
        $this->js       = ['plug/wesley/wesleyPlug.js','plug/wesley/base.js'];
    }
}
