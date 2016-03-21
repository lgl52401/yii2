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
    public $username;
    public $password;
    public $password_rep;
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
                [['password_rep'],'required','on'=>'create'],
                ['password_rep','compare','compareAttribute'=>'password','on'=>'create'],

                [['username','password'],'required'],

                
                ['verifyCode', 'captcha','captchaAction'=>'login/captcha','on'=>'index'],

                [['status'], 'integer'],
                [['reg_time'], 'safe'],
                [['username'], 'string', 'max' => 30],
                [['password'], 'string', 'max' => 32],
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
            'password_rep'  => Yii::t('form_label', 'Password_rep'),
            'status'        => Yii::t('form_label', 'Status'),
            'reg_time'      => Yii::t('form_label', 'Reg Time'),
            'verifyCode'    => Yii::t('form_label', 'verifyCode'),
            ];
    }
}
