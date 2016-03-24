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
        parent::loadAsset();
        $this->css      = ['backend/css/base.css','plug/font-awesome/css/font-awesome.min.css','plug/wesley/wesleyPlug.css'];
        $this->js       = ['backend/js/base.js','plug/wesley/wesleyPlug.js'];
    }
}
