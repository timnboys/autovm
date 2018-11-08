<?php

class Api
{
	const ACTION_ENCRYPT = '/encrypt';
    const ACTION_DS = '/ds';
	
	protected $url,
			  $data,
			  $timeout;
			  
	
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
	
	public function request($action)
	{
		$c = curl_init();
		
		curl_setopt($c, CURLOPT_URL, $this->getUrl() . $action);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		
		if ($time = $this->getTimeout()) {
			curl_setopt($c, CURLOPT_TIMEOUT, $time);
		}
		
		#curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);

		if ($this->data) {
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $this->buildParams($this->data));
		}

		$result = curl_exec($c);
				  curl_close($c);

		$result = @json_decode($result);
		
		if (!is_object($result) || $result->ok != 'true') {
			return false;
		}
		
		return $result;
	}
	
	public function buildParams($params)
	{
		return http_build_query($params);
	}
}
