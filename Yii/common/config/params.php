<?php
return [
		'user.passwordResetTokenExpire' => 3600,
		'adminEmail' 	=>'admin@example.com',
		'supportEmail' 	=>'support@example.com',
			'captcha'=>[
						'class'		=>'libs\base\BCaptchaAction', 
						'type'		=>3,
						'backColor'	=>0xFFFFFF,
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
						'transparent'=>true,
						'maxLength'	=>5,  
						'minLength'	=>4, 
						'width'		=>'80',
						'height'	=>'36' 
						]
];
