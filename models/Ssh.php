<?php

namespace app\models;

class Ssh
{
    private $_ip;
    private $_port = 22;
    private $_username;
    private $_password;

    private $_con;

    public function __construct()
    {
        if(!function_exists('ssh2_connect'))
            exit('please enable ssh2_connect');
    }

    public function connect($ip,$port = 22)
    {
        $this->_ip = $ip;
        $this->_port = $port;

        $methods = array(
            'client_to_server'=>array(
                'crypt'=>'3des-cbc',
            ),
            'server_to_client'=>array(
                'crypt'=>'3des-cbc',
            ),
        );

        if(!$this->_con = ssh2_connect($ip,$port,$methods))
            return false;

        return true;
    }

    public function login($username,$password)
    {
        if(!$this->_con)
            return false;

        if(!ssh2_auth_password($this->_con,$username,$password))
            return false;

        return true;
    }

    public function exec($command)
    {
        if(!$this->_con)
            return false;

        $stream = ssh2_exec($this->_con,$command);
        $err = ssh2_fetch_stream($stream,SSH2_STREAM_STDERR);
        stream_set_blocking($stream,true);
        stream_set_blocking($err,true);

        $result = stream_get_contents($stream);
        if(!$result)
            $result = stream_get_contents($err);

        fclose($stream);
        fclose($err);

        return $result;
    }

    public function disconnect($command = 'exit')
    {
        if(!$this->_con)
            return false;

        ssh2_exec($this->_con,$command);
        $this->_con = null;

        return true;
    }
}