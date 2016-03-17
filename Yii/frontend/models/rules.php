<?php
//验证规则
/*
	正则匹配
	中文：/[\x{4e00}-\x{9fa5}]+/u
	字母下划线和横杆：/^[a-z0-9\-_]+$/
*/
public function rules()
{
    return [
        //账号、密码、确认密码、邮箱、验证码必须
        [['username','password','password_rep','email'],'required'],

        //账号只能是汉字/数字/下划线,不能包含空格
        ['username','match','pattern'=>'/[\x{4e00}-\x{9fa5}]+/u'],
        //用户名最大10位，最小3位
        ['username','string','max'=>12,'min'=>2],
        //用户名/邮箱唯一
        //['username','unique','targetClass'=>'\backend\modules\pub\models\YiiUser','message'=>'账号已存在'],
        //['email','unique','targetClass'=>'\backend\modules\pub\models\YiiUser','message'=>'邮箱已被绑定'],
        //去除空格
        [['username','email'],'trim'],
        [['username'],'default','value'=>time(),'on'=>['sign']]
        //密码最大16位，最小6位
        ['password','string','max'=>16,'min'=>6],
        //验证邮箱
        ['email','email','message'=>'邮箱不规范'],
        //验证两次密码是否一致
        ['password_rep','compare','compareAttribute'=>'password','message'=>'两次密码不一致','on'=>'index'],
        //验证码
       ['verifyCode', 'captcha','captchaAction'=>'tool/captcha'],
       [['image'], 'image', 'enableClientValidation' => true,   'maxSize' => 1024, 'message' => '您上传的文件过
大', 'on' => ['create']],
    ];
}