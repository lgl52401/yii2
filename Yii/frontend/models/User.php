<?php
namespace app\models;
use Yii;
use libs\libraries\Multiple_cache;

class User extends \libs\base\BActiveRecord
{
    public $username;
    public $password;
    public $password_rep;
    public $email;
    public $verifyCode;
    //验证规则
    public function rules()
    {
        return [
         [['route_code'],'default','value'=>SYS_TIME],
            //账号、密码、确认密码、邮箱、验证码必须
            [['username','password','password_rep','email'],'required'],
            //账号只能是汉字/数字/下划线,不能包含空格
            //['username','match','pattern'=>'/[\x{4e00}-\x{9fa5}]+/u'],
            //用户名最大10位，最小3位
           ['username','match','pattern'=>'/^[a-z0-9\-_]+$/'],
            ['username','string','max'=>12,'min'=>2 ,'tooLong'=>'用户名请输入长度为4-14个字符', 'tooShort'=>'用户名请输入长度为2-7个字'],
            //用户名/邮箱唯一
            ['username','unique','message'=>'账号已存在'],
            //['email','unique','targetClass'=>'\backend\modules\pub\models\YiiUser','message'=>'邮箱已被绑定'],
            //去除空格
            [['username','email'],'trim'],
            //密码最大16位，最小6位
            ['password','string','max'=>16,'min'=>6],
            //验证邮箱
            ['email','email','message'=>'邮箱不规范'],

            //验证两次密码是否一致
            ['password_rep','compare','compareAttribute'=>'password','message'=>'两次密码不一致','on'=>'index'],
            //验证码
           // ['verifyCode', 'captcha','captchaAction'=>'tool/captcha'],
            [['image'], 'image', 'enableClientValidation' => true,   'maxSize' => 1024, 'message' => '您上传的文件过
大', 'on' => ['create']],
        ];
    }

/*    public function scenarios()
    {
        return [
            //'index' => ['username', 'image', 'content'],
            'update' => ['title', 'content'],
        ];
    }*/

     public static function tableName()
    {
        return '{{%route}}';
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'password_rep'=>'确认密码',
            'verifyCode'=>'验证码',
            'email'=>'邮箱',
        ];
    }
    public function register(){
        if ($this->validate()) {
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
}