<?php
return [
        'FileCache'=> [
            'class' => 'yii\caching\FileCache',
            'directoryLevel'=>2
        ],
        'MemCache'=>[
            'class' => 'yii\caching\MemCache',
            'servers' => [
                            [
                                'host' => '127.0.0.1',
                                'port' => 11211,
                                'weight' => 60,
                            ],
                            [
                                'host' => '127.0.0.1',
                                'port' => 11211,
                                'weight' => 40,
                            ],
                        ],
        ],
        'DbCache' => [
                    'class'      => 'yii\caching\DbCache',
                    'db'         => 'db',
                    'cacheTable' => 'lgl_cache',
        ],
        'RedisCache'=>[
            'class' => 'yii\redis\Cache',
        ],
        'redis' => [
                'class'     => 'yii\redis\Connection',
                'hostname'  => 'localhost',
                'port'      => 6379,
                'database'  => 0,
        ],
];
