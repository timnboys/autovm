<?php

namespace app\modules\api\controllers;
use app\models\Server;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use app\models\Ip;
use app\modules\api\filters\Auth;
use app\modules\api\components\Status;

class ServerController extends Controller
{
    public function behaviors()
    {
        return [
            Auth::className(),
        ];
    }
    
    public function actionIp()
    {
        $serverId = Yii::$app->request->post('serverId');
        $serverId = explode(',', $serverId);
        
        $ips = Ip::find()->leftJoin('vps_ip', 'vps_ip.ip_id = ip.id')
                ->andWhere('vps_ip.id IS NULL')
                ->andWhere(['ip.server_id' => $serverId])
                ->orderBy('ip.id ASC')
                ->isPublic()
                ->all();

        #$ips = Ip::find()->where(['server_id' => $serverId])->all();
        
        return [
            'ok' => true, 
            'ips' => ArrayHelper::map($ips, 'id', 'ip'),
        ];
    }
}