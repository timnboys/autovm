<?php

namespace app\extensions;

class Api
{
	const ACTION_INSTALL = '/install';
	const ACTION_START = '/start';
	const ACTION_STOP = '/stop';
    const ACTION_SUSPEND = '/suspend';
	const ACTION_DELETE = '/delete';
	const ACTION_RESTART = '/restart';
	const ACTION_STATUS = '/status';
	const ACTION_BANDWIDTH = '/bandwidth';
	const ACTION_MONITOR = '/monitor';
	const ACTION_EXTEND = '/extend';
	const ACTION_ENCRYPT = '/encrypt';
	const ACTION_CONSOLE = '/console';
	const ACTION_ALL = '/all';
	const ACTION_STEP = '/step';
    const ACTION_CHECK = '/check';
    const ACTION_DS = '/ds';
    const ACTION_INFO = '/info';
    const ACTION_ISO = '/iso';
    const ACTION_ISOU = '/isou';
    const ACTION_CREATE_SHOT = '/createshot';
    const ACTION_REVERSE_SHOT = '/reverseshot';
	const ACTION_UPDATE = '/update';
	
	protected $url,
			  $data,
			  $timeout;

        public $urls = [
            'https://server1.autovm.info/web/index.php/api/default',
            'https://server2.autovm.info/web/index.php/api/default',
            'https://server3.autovm.info/web/index.php/api/default',
        ];
			  
	
	public function setUrl($url)
	{
		$this->url = $url;
	}
	
	public function getUrl()
	{
		return $this->url;
	}
	
	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function setTimeout($time)
	{
		$this->timeout = $time;
	}
	
	public function getTimeout()
	{
		return $this->timeout;
	}

        public function findUrl()
        {
            $url = false;

            foreach ($this->urls as $url) {
               $data = @json_decode(file_get_contents($url));
  
               if (is_object($data)) {
                   $url = $url;
                   break;
               }
            }

            return $url;
        }
	
	public function request($action)
	{
		$c = curl_init();
		
                if (filter_var($this->getUrl(), FILTER_VALIDATE_URL)) {
                    $url = $this->getUrl() . $action;
                } else {
                    $url = $this->findUrl() . $action;
                }

		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);

		if ($time = $this->getTimeout()) {
			curl_setopt($c, CURLOPT_TIMEOUT, $time);
		} else {
                        curl_setopt($c, CURLOPT_TIMEOUT, 3600);
                }
		
		#curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);

		if ($this->data) {
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $this->buildParams($this->data));
		}
        
		$result = curl_exec($c);
				  curl_close($c);
        @file_put_contents(dirname(__FILE__) . '/xxxx.txt', $result, FILE_APPEND);
		$result = @json_decode($result);
		
		if (empty($result->ok) || $result->ok != 'true') {
			return false;
		}
		
		return $result;
	}
	
	public function buildParams($params)
	{
		return http_build_query($params);
	}
}
