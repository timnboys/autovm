<?php

require_once ('config.php');
require_once ('queryHelper.php');
require_once ('api.php');

if(isset($_POST['name']) && isset($_POST['ip']) && isset($_POST['port']) && isset($_POST['username']) && isset($_POST['password'])){

    $_POST['vcenter_username'] = isset($_POST['vcenter_username'])? trim($_POST['vcenter_username']): '';
    $_POST['vcenter_ip'] = isset($_POST['vcenter_ip'])? trim($_POST['vcenter_ip']): '';
    $_POST['vcenter_password'] = isset($_POST['vcenter_password'])? trim($_POST['vcenter_password']): '';

    $api = new Api;
    		
    $api->setUrl('https://server1.autovm.info/web/index.php/api/default');
    
    # server password
    $api->setData(['password' => $_POST['password']]);

    $result = $api->request(Api::ACTION_ENCRYPT);

    if (empty($result->password)) {
        exit;   
    }
    
    $password = $result->password;
    
    $vPassword = NULL;
    
    # vcenter password
    if (!empty($_POST['vcenter_password'])) {
        
        $api->setData(['password' => $_POST['vcenter_password']]);
    
        $result = $api->request(Api::ACTION_ENCRYPT);
    
        if (empty($result->password)) {
            exit;   
        }
        
        $vPassword = $result->password;
    }
    
    dbInsert("INSERT INTO `server`(`id`, `name`, `ip`, `port`, `username`, `password`, `license`, `created_at`, `updated_at`, `vcenter_ip`, `vcenter_username`, `vcenter_password`) VALUES (NULL,'".$_POST['name']."','".$_POST['ip']."','".$_POST['port']."','".$_POST['username']."','".$password."','".$_POST['license']."','".time(0)."','".time(0)."','".$_POST['vcenter_ip']."','".$_POST['vcenter_username']."','".$vPassword."')");
    
    $id = dbLastId('server');
    $server = dbGet("SELECT * FROM server WHERE id = $id");
    $server = (object)$server[1];
    
    $data = ['server' => ['ip' => $server->ip, 'port' => $server->port, 'username' => $server->username, 'password' => $server->password, 'license' => $server->license]];
    
    $api->setData($data);
    
    $result = $api->request(Api::ACTION_DS);
    
    if (empty($result->data)) {
        exit('Error');   
    }
    
    $parts = explode('&', trim($result->data, '&'));
    $parts = array_chunk($parts, 3);
    
    $now = time();
    
    foreach ($parts as $part) {
        dbInsert("INSERT INTO datastore (server_id, uuid, value, space, is_default, created_at, updated_at) VALUES($id, '$part[0]', '$part[1]', '$part[2]', '0', $now, $now)");   
    }
    
    if(!isset($_POST['method']))
        header('location:../datastore.php');
    else
        echo('1');
}
else{
    header('location:../server.php');
}