<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%route}}".
 *
 * @property integer $route_id
 * @property string $route_code
 * @property integer $vendor_id
 * @property integer $duration
 * @property integer $advance
 * @property string $route_image
 * @property integer $status
 * @property integer $sort_order
 * @property integer $dep_id
 * @property integer $check_inventory
 * @property string $date_start
 * @property string $date_end
 * @property string $timezone
 * @property string $created
 */
class Aa extends \lib\base\BActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%aa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['id'], 'integer'],
            [['sublit','title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Route ID',
            'title' => 'Route Code',
            'sublit' => 'Vendor ID',

        ];
    }

   
}
