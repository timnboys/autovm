<?php

namespace app\modules\cron\controllers;

use Yii;
use yii\web\Controller;

use app\models\Vps;
use app\models\Server;

use app\extensions\Api;

class StatusController extends Controller
{
	public function actionIndex()
	{
		$servers = Server::find()->all();

		foreach ($servers as $server) {
		
			$data = [
				'server' => $server->getAttributes(),
			];
			
			$api = new Api;
			$api->setUrl(Yii::$app->setting->api_url);
			$api->setData($data);
			
			$result = $api->request(Api::ACTION_ALL);
			
			if (!$result) {
				continue;
			}
			
			$virtualServers = Vps::find()->where(['server_id' => $server->id])->all();
			
			foreach ($virtualServers as $vps) {
				
				$ip = $vps->ip->ip;
				
				$status = stripos($result->data, $ip);
				echo $result->data;
				if ($status) {
					$vps->power = Vps::ONLINE;
				} else {
					$vps->power = Vps::OFFLINE;
				}
				
				$vps->save(false);
			}
		}
	}
}