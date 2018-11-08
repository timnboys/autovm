<?php

$FileName = "config.php";

if(file_exists($FileName))
    unlink($FileName);

$FileHandle = fopen($FileName, 'w') or die("can't create database file");

$stringData = "<?php

define('DB_HOST', '".$_POST["mysql_host"]."');
define('DB_NAME', '".$_POST["mysql_database"]."');
define('DB_USER', '".$_POST["mysql_username"]."');
define('DB_PASS', '".$_POST["mysql_password"]."');
define('DB_PORT', 3306);";

fwrite($FileHandle, $stringData);

fclose($FileHandle);

require_once ('config.php');
require_once ('queryHelper.php');

$filename = 'database.sql';

$email = $_POST['email'];

$password = hash('sha1', $_POST['password'] . 'abchhjkfuerqwelo');

$connection = dbConnect();

$connection->select_db(DB_NAME) or header('location:../install.php');

$data = file_get_contents(dirname(__FILE__) . '/' . $filename);

$data = str_replace('{email}', $email, $data);

$data = str_replace('{password}', $password, $data);

$lines = explode(';', $data);

foreach ($lines as $line) {
    $connection->query($line);
}

$FileName = "../../../config/db.php";

if(file_exists($FileName))
    unlink($FileName);

$FileHandle = fopen($FileName, 'w') or die("can't create database file");

$stringData = "<?php

return [
'class' => 'yii\db\Connection',
'dsn' => 'mysql:host=".DB_HOST.";dbname=".DB_NAME."',
'username' => '".DB_USER."',
'password' => '".DB_PASS."',
'charset' => 'utf8',
];";

fwrite($FileHandle, $stringData);

fclose($FileHandle);

header('location:../server.php');