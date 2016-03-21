<?php
return [
    'class' 		=> 'yii\db\Connection',
    'dsn' 			=> 'mysql:host=localhost;dbname=yii2_1;charset=utf8',// 配置主服务器
    'username' 		=> 'root',
    'password' 		=> '',
    'tablePrefix' 	=> 'lgl_',
    'charset' 		=> 'utf8',
    'enableSchemaCache'     =>true,
    'schemaCacheDuration'   =>3600,
    'schemaCache'           =>'cache',
    'slaveConfig' 	=> [// 配置从服务器
							'username' 	 => 'root',
							'password' 	 => '',
							'attributes' => 
							[
								PDO::ATTR_TIMEOUT => 10,
							],
    				   ],
    'slaves' 		=> [// 配置从服务器组
					        ['dsn' => 'mysql:host=localhost;dbname=yii2_1;charset=utf8']
					    ]
];