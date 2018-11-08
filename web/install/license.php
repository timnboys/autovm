<?php

$ip = @$_GET['ip'];

if (empty($ip)) {
	exit(json_encode(['ok' => false]));
}

$data = @json_decode(file_get_contents('http://server1.autovm.info/web/index.php/api/test/test?ip=' . $ip));

if (empty($data)) {
	exit(json_encode(['ok' => false]));	
}

exit(json_encode(['ok' => true, 'secret' => @$data->secret]));
