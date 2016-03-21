<?php
namespace app\models;
use Yii;
use libs\libraries\Multiple_cache;
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
class Route extends \libs\base\BActiveRecord
{
    public $route_key = 'route_data_';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%route}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'duration','route_code','sort_order','timezone'],'required'],
            [['vendor_id', 'duration', 'advance', 'status', 'sort_order', 'dep_id', 'check_inventory', 'date_start', 'date_end', 'created'], 'integer'],
            [['route_code'], 'string', 'max' => 222264],
            [['route_image'], 'string', 'max' => 23350],
            [['timezone'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route_code' => 'Route Code',
            'vendor_id' => 'Vendor ID',
            'duration' => 'Duration',
            'advance' => 'Advance',
            'route_image' => 'Route Image',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'dep_id' => 'Dep ID',
            'check_inventory' => 'Check Inventory',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'timezone' => 'Timezone',
            'created' => 'Created',
        ];
    }

    /**
     * 获取缓存数据
     */
    public function getCache_Route($id = '')
    {
        $temp = array(
                    'cache_key'     =>$this->route_key,
                    'primary_key'   =>'route_id',
                     );
        $data = Multiple_cache::set_cache($id,$this,$temp,'FileCache');
        return $data;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            $fields = $this->rules();
            $this->filterData([$fields[1][1]=>$fields[1][0],'html'=>['route_image','route_code']]);
            /*if($this->isNewRecord)
            {

            }*/
            unset($this->created);
            unset($this->date_end);
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function afterSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if($insert)
            {
                //echo 'insert'.$insert;Yii::$app->db->getLastInsertID();
            }
            else
            {
                Yii::$app->FileCache->delete($this->route_key. $this->route_id);
                //echo 'update'.$insert;
            }    
        }
    }

    public function _delete($ids = '')
    {
        $ids = to_intval($ids,2);
        if($ids)
        {
            $this->deleteAll(['route_id'=>$ids]);
            foreach ($ids as $key => $val)
            {
                Yii::$app->FileCache->delete($this->route_key.$val);
            }
            return true;
        }
        return false;
    }
}
