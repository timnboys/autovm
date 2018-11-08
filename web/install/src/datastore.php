<?php

require_once ('config.php');
require_once ('queryHelper.php');

if(isset($_POST['id']) && isset($_POST['value'])){
    dbInsert("INSERT INTO `datastore`(`id`, `server_id`, `value`, `space`, `is_default`, `created_at`, `updated_at`) VALUES (NULL,'".$_POST['id']."','".$_POST['value']."','".$_POST['space']."','".$_POST['defalt']."','".time(0)."','".time(0)."')");
    echo('1');
}
if(isset($_POST['id']) && isset($_POST['from_ip'])){
    $fromIP = explode('.',$_POST['from_ip']);
    $toIP = explode('.',$_POST['to_ip']);
    for($i = $fromIP['3'] ; $i <= $toIP['3'] ; $i++){
        $ip = $fromIP['0'].'.'.$fromIP['1'].'.'.$fromIP['2'].'.'.$i;
        dbInsert("INSERT INTO `ip`(`id`, `server_id`, `ip`, `gateway`, `netmask`, `mac_address`, `is_public`, `created_at`, `updated_at`) VALUES (NULL,'".$_POST['id']."','".$ip."','".$_POST['gateway']."','".$_POST['netmask']."','".$_POST['mac_address']."','".$_POST['public']."','".time(0)."','".time(0)."')");
    }
    echo('1');
}
if(isset($_POST['method']) && isset($_POST['id'])){
    dbDelete(`server`,$_POST['id']);
}