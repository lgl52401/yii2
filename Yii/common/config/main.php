<?php
$data        = dirname(dirname(dirname(__DIR__))).'/data/';
$runtimePath = $data.APP_DIR.'_runtime';
$sessionPath = $data.APP_DIR.'_session';
$Ymd         = date('Y-m-d');
$config = [
    'vendorPath'  =>dirname(dirname(__DIR__)) . '/vendor',
    'timeZone'    =>'America/New_York',
    'charset' 	  =>'utf-8', 
    'language'    =>'zh-CN',// 设置目标语言为中文
    'sourceLanguage'=>'en-US',// 设置源语言为英语
    'defaultRoute'=>'site/index',
    //'catchAll'  =>['site/index'],
    'runtimePath' =>$runtimePath,
    'components'  =>[
            'request' => [ 
                        'enableCsrfValidation' => false, 
                        ],
            'i18n'=>[
                'translations'=>[
                                'app*'=>[
                                        'class'         =>'yii\i18n\PhpMessageSource',
                                        'basePath'      =>'@app/../language',
                                        'sourceLanguage'=>'en-US',
                                        'fileMap'       =>[
                                                            /*'app'       =>'app.php',
                                                            'app/error' =>'error.php'*/
                                                            ],
                                        ],
                                    ],
                                ],
        'errorHandler'=>[
                        'errorAction'=>'errors/error',
                        ],
        'cache'  =>['class' => 'yii\caching\FileCache','directoryLevel'=>2],
        'session'=>[
                    'class'        =>'yii\web\Session',
                    'name'         =>APP_DIR.'_SID',
                    'cookieParams' =>['httponly'=>true,'lifetime' =>43200,'path' => '/', 'domain' => ''],
                	'timeout'      =>360000,
                	'useCookies'   =>true,
                    'savepath'     =>$sessionPath
                    ],
        'log' => [
                'traceLevel'=>YII_DEBUG ? 3 : 0,
                'targets'   =>[
                            	[
                                'class'     =>'yii\log\FileTarget',
                                'categories'=>['yii\db\*','app\models\*'],
                                'levels'    =>['error','warning'],
                                'logVars'   => ['_POST'],
                                'logFile'   =>'@runtime/logs/sql/'.$Ymd.'/sql_error.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'categories'=>['yii\db\Command::execute'],
                                'levels'    =>['info'],
                                'logVars'   => [],
                                'logFile'   =>'@runtime/logs/sql/'.$Ymd.'/sql_execute.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'categories'=>['yii\db\Command::query','app\models\*'],
                                'levels'    =>['info'],
                                'logVars'   => [],
                                'logFile'   =>'@runtime/logs/sql/'.$Ymd.'/sql_query.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'categories'=>['app\models\*'],
                                'levels'    =>['info'],
                                'logVars'   => [],
                                'logFile'   =>'@runtime/logs/models/'.$Ymd.'/models.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'levels'    =>['error'],
                                'except'    =>['yii\db\*','app\models\*'],
                                'logFile'   =>'@runtime/logs/page/'.$Ymd.'/page_error.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'levels'    =>['warning'],
                                'except'    =>['yii\db\*','app\models\*'],
                                'logFile'   =>'@runtime/logs/page/'.$Ymd.'/page_warning.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'levels'    =>['info'],
                                'categories'=>['_*'],
                                'logFile'   =>'@runtime/logs/page/'.$Ymd.'/page_info.log'
                                ],
                                [
                                'class'     =>'yii\log\FileTarget',
                                'levels'    =>['trace'],
                                'logFile'   =>'@runtime/logs/trace/'.$Ymd.'trace.log'
                                ]
                            ],
                ],
        'urlManager'=>[
						'enablePrettyUrl'		=>true, //对url进行美化
						'showScriptName' 		=>false,//隐藏index.php
						'suffix' 		 		=>'.shtml',//后缀
						'enableStrictParsing'	=>false,//不要求网址严格匹配，则不需要输入rules
						'rules' => [
									'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
									//标准的控制器/方法显示
									'<controller:\w+>/<action:\w+>'				=>'<controller>/<action>',
									]
						],
        'assetManager'=>[
				'basePath' => '@static/assets',
				'baseUrl'  => staticDir.'/assets',
		      	'bundles'  => [
					      		/*'yii\web\JqueryAsset' =>
			      				[
									'sourcePath' => null,
									'js' => ['//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js']
		                		],
				                'yii\bootstrap\BootstrapAsset' => 
				                [
									'sourcePath' => null,
									'js' => ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js'],
									'css' => ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css']
								],*/
						     ],
	  					]
    		],
    
];
$cache = require(GLOBALDIR.'cache.php');
if(is_array($cache))
{
	$config['components'] += $cache;
}
$db = require(GLOBALDIR.'db.php');
if(is_array($db))
{
    $config['components']['db'] = $db;
}
return $config;