<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'image'=>'yii\image\ImageDriver',
        'driver'=>'Imagick',

    ],
];
