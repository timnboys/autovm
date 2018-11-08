<?php

$folder = dirname(__FILE__) . '/install/';

if (file_exists('../config/db.php') && is_dir($folder)) {
    header('Location:install/complete.php');
    die();
}


if (!file_exists('../config/db.php') && is_dir($folder)) {
    header('Location:install/');
    exit;
}


// comment out the following two lines when deployed to production
#defined('YII_DEBUG') or define('YII_DEBUG', true);
#defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();