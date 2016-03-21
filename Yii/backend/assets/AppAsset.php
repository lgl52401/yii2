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
        $this->css      = ['backend/css/main.css'];
    }
}
