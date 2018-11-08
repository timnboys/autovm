<?php

namespace app\modules\cron\controllers;

use Yii;
use yii\web\Controller;

use app\models\Vps;
use app\models\VpsAction;
use app\models\Plan;
use app\models\Server;
use app\extensions\Api;
use app\models\Bandwidth;

class BandwidthController extends Controller
{
    public function actionIndex()
    {
    	$this->actionStatus();
    	
        $servers = Server::find()->all();
        
        foreach ($servers as $server) {
            
            $data = [
                'server' => $server->getAttributes(),
            ];

            $api = new Api;
            $api->setUrl(Yii::$app->setting->api_url);
            $api->setData($data);

            $result = $api->request(Api::ACTION_BANDWIDTH);
            
            if (!$result) {
                continue;
            }

            #$file = Yii::getAlias('@app/runtime/bandwidth/');
            #$file .= date('YmdHi') . '.txt';

            #file_put_contents($file, print_r($result, true), FILE_APPEND);
            
            $virtualServers = @json_decode($result->data);

            if ($virtualServers) {
            
                foreach ($virtualServers as $ip => $data) {

                    $vps = Vps::findByIp($ip);

                    if ($vps) {

                        echo $vps->id;
                        echo '<br>';
                        echo $data->bandwidth;
                        echo '<br>';

                        # new
                        $newUsed = ceil($data->bandwidth / 1024 / 1024);

                        foreach ($virtualServers as $ip2 => $data2) {
                            $newUsed2 = ceil($data2->bandwidth / 1024 / 1024);

                            if ($ip2 != $ip && $newUsed == $newUsed2) {
                                continue 2;
                            }
                        }

                        $plan = Plan::find()->where(['id'=>$vps->plan_id])->one() ;

                        $bw = ($plan ? $plan->band_width : $vps->vps_band_width);

                        # old
                        $oldBandwidth = Bandwidth::find()->where(['vps_id' => $vps->id])->orderBy('id DESC')->one();
                        $oldUsed = ($oldBandwidth ? $oldBandwidth->pure_used : 0);
                        
                        # older
                        $olderBandwidth = Bandwidth::find()->where(['vps_id' => $vps->id])->orderBy('id DESC')->offset(1)->one();
                        $olderUsed = ($olderBandwidth ? $olderBandwidth->pure_used : 0);
                        
                        # total
                        $totalUsed = Bandwidth::find()->where(['vps_id' => $vps->id])->orderBy('id DESC')->one();
                        $totalUsed = ($totalUsed ? $totalUsed->used : 0);
                        
                        # total active
                        $totalActiveUsed = Bandwidth::find()->where(['vps_id' => $vps->id])->active()->orderBy('id DESC')->one();
                        $totalActiveUsed = ($totalActiveUsed ? $totalActiveUsed->used : 0);
                        
                        

                        if (!$oldUsed || !$olderUsed) {
                            $newTotalUsed = 0;
                        }

                        if ($newUsed == $oldUsed) {
                                continue;
                        }

                        if ($olderUsed > $oldUsed && $oldUsed > $newUsed) {
                            $newTotalUsed = ($totalUsed - ($oldUsed + $olderUsed) ) + $newUsed; 
                            #file_put_contents(dirname(__FILE__) . '/s.txt', 1, FILE_APPEND);
                        }
                        
                        if ($olderUsed < $oldUsed && $oldUsed < $newUsed) {
                            $newTotalUsed = ($totalUsed - $oldUsed) + $newUsed;   
                            #file_put_contents(dirname(__FILE__) . '/s.txt', 2, FILE_APPEND);
                        }
                        
                        if ($olderUsed > $oldUsed && $oldUsed < $newUsed) {
                            $newTotalUsed = ($newUsed - $oldUsed) + $totalUsed;
                            #file_put_contents(dirname(__FILE__) . '/s.txt', 3, FILE_APPEND);
                        }
                        
                        if ($olderUsed < $oldUsed && $oldUsed > $newUsed) {
                            $newTotalUsed = $totalUsed + $newUsed;
                            #file_put_contents(dirname(__FILE__) . '/s.txt', 4, FILE_APPEND);
                        }
                        
                        $bandwidth = new Bandwidth;
                        $bandwidth->vps_id = $vps->id;
                        $bandwidth->used = $newTotalUsed;
                        $bandwidth->pure_used = $newUsed;
                        $bandwidth->save(false);

                        if ($bw > 0 && $totalActiveUsed >= ($bw*1024)) {

                            $data = [
                            'ip' => $vps->ip->getAttributes(),
                            'vps' => $vps->getAttributes(),
                            'server' => $server->getAttributes(),
                            ];

                            $api->setData($data);

                            $result = $api->request(Api::ACTION_SUSPEND);

                            if ($result) {
                                $vps->status = Vps::STATUS_INACTIVE;
                                $vps->save(false);

                                $action = new VpsAction;
                                
                                $action->vps_id = $vps->id;
                                $action->action = VpsAction::ACTION_SUSPEND;
                                $action->description = 'By cron';
                                
                                $action->save(false);
                            }
                        }
                    }
                } 
            }
        }
    }
    
    public function actionStatus()
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
