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
class TableAsset extends BAsset
{
    public function init()
    {
        parent::init();
        $this->css      = ['plug/font-awesome/css/font-awesome.min.css','plug/bootstrap-plug/data_tables/dataTables.bootstrap.css','plug/bootstrap-plug/data_tables/fixedHeader.bootstrap.min.css','plug/wesley/wesleyPlug.css','backend/css/base.css'];
        $this->js       = ['plug/bootstrap-plug/data_tables/jquery.dataTables.min.js','plug/bootstrap-plug/data_tables/dataTables.bootstrap.js','plug/bootstrap-plug/data_tables/dataTables.fixedHeader.min.js','backend/js/icon.js','plug/wesley/wesleyPlug.js','plug/wesley/base.js'];
    }
}
