<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%routes}}".
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
class Routes extends \lib\base\BActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%routes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor_id', 'duration', 'advance', 'status', 'sort_order', 'dep_id', 'check_inventory', 'date_start', 'date_end', 'created'], 'integer'],
            [['route_code'], 'string', 'max' => 64],
            [['route_image'], 'string', 'max' => 50],
            [['timezone'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route_id' => Yii::t('app', 'Route ID'),
            'route_code' => Yii::t('app', '????'),
            'vendor_id' => Yii::t('app', '???id'),
            'duration' => Yii::t('app', '????'),
            'advance' => Yii::t('app', '??????'),
            'route_image' => Yii::t('app', '??'),
            'status' => Yii::t('app', '1-?? ; 2-??, -1-??'),
            'sort_order' => Yii::t('app', '??'),
            'dep_id' => Yii::t('app', '????'),
            'check_inventory' => Yii::t('app', '?????? 1-? -2?'),
            'date_start' => Yii::t('app', '??????'),
            'date_end' => Yii::t('app', '??????'),
            'timezone' => Yii::t('app', '????'),
            'created' => Yii::t('app', '????'),
        ];
    }

    /**
     * @inheritdoc
     * @return RoutesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoutesQuery(get_called_class());
    }
}
