<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $aid
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $reg_time
 */
class Admin extends \libs\base\BActiveRecord
{
    public $admin_key = 'admin_data_';
    public $password_rep;
    public $password_old;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['password_rep','password_old'],'required','on'=>['account','create','update']],
                ['password_rep','compare','compareAttribute'=>'password','on'=>['account','create','update']],

                [['status'],'required','on'=>['create','update']],

                ['verifyCode', 'captcha','captchaAction'=>'tool/captcha','on'=>'index'],

                [['username','password'],'required'],
                ['username','match','pattern'=>'/^[a-z][a-z0-9_]{2,}/','message'=>Yii::t('form_verify', 'form_validation_alpha_dash')],

                [['status'], 'integer'],
                [['reg_time'], 'safe'],
                [['username'], 'string', 'min'=>3, 'max' => 30],
                [['password','password_old'], 'string', 'min'=>6, 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid'           => Yii::t('form_label', 'Id'),
            'username'      => Yii::t('form_label', 'Username'),
            'password'      => Yii::t('form_label', 'Password'),
            'password_rep'  => Yii::t('form_label', 'Password rep'),
            'password_old'  => Yii::t('form_label', 'Password old'),
            'status'        => Yii::t('form_label', 'Status'),
            'reg_time'      => Yii::t('form_label', 'Reg Time'),
            'verifyCode'    => Yii::t('form_label', 'verifyCode'),
            ];
    }

    /**
    * 用户密码加密
    *
    * @property string $password
    * @property string $reg_time
    */    
    public function encryptPwd($pwd,$ext='')
    {
        return md5(md5($pwd).md5($ext));
    }

    /**
    * 获取缓存数据
    *
    * @property integer $aid
    */
    public function getCache_Admin($id = '')
    {
        $temp = array(
                    'cache_key'     =>$this->admin_key,
                    'primary_key'   =>'aid',
                     );
        $data = Multiple_cache::set_cache($id,$this,$temp,'FileCache');
        return $data;
    }

    /**
    * 判断用户是否登录
    *
    */    
    public function checkLogin()
    {
        if(Yii::$app->session['aid'])
        {
            return true;
        }
        else
        {
            return false;
        } 
    }

    /**
    * 退出系统
    *
    */
    public function logout()
    {
        $session = Yii::$app->session;
        if (!$session->isActive)$session->open();
        $session->destroy();
        return true;
    }

    /**
    * 用户登录
    *
    * @property Boolean 创建session
    */    
    public function login($create = true)
    {
        $result = $this->outResult();
        if($this->validate())
        {
            $result['msg'] = Yii::t('model', 'Userid and/or Password incorrect. Please try again');
            $userInfo      = $this::find()->where(['username' => $this->username])->limit(1)->one();
            if($userInfo)
            {
                $pwd = $this->encryptPwd($this->password,$userInfo['reg_time']);
                if($userInfo['status'] != 1)//禁止登录
                {
                    $result['msg'] = Yii::t('model', 'The account is disabled');
                    return $result;
                }
                elseif($userInfo['password'] != $pwd)//密码错误
                {
                    $result['msg'] = Yii::t('model', 'Userid and/or Password incorrect. Please try again');
                    return $result;
                }
                else
                {
                    if($create)//是否生成session
                    {
                        $session        = Yii::$app->session;
                        $session['aid'] = $userInfo['aid'];
                    }
                    else
                    {
                        $result['data'] = $row['uid'];
                    }    
                    $result['success'] = true;
                    $result['msg']     = Yii::t('model','Login successful');
                }
            }
        }
        return $result;
    }

    /**
    * 用户注册
    *
    * @property Boolean 创建session
    */     
    public function register()
    {
        if ($this->validate()){
            print_r($this->route_code);
            exit('aaa');
            $user = new YiiUser();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }

    /**
    * 用户删除
    *
    * @property integer|array $ids
    */
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

    /**
    * 用户保存数据之前操作
    *
    * @property Boolean $insert
    */  
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            $this->filterData(['integer'=>['status']]);
            if($this->isNewRecord)//添加
            {
                $this->reg_time = date('Y-m-d',SYS_TIME);
            }
            else//修改
            {
                unset($this->reg_time,$this->aid,$this->username);
            }    
            return true;
        } 
        else 
        {
            return false;
        }
    }

    /**
    * 用户保存数据之后操作
    *
    * @property Boolean $insert
    */ 
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
                Yii::$app->FileCache->delete($this->admin_key. $this->aid);
                //echo 'update'.$insert;
            }   
        }
    }
}