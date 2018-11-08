<?php

namespace app\modules\cron\controllers;

use Yii;
use yii\web\Controller;

use app\models\Vps;
use app\models\Bandwidth;

class ResetController extends Controller
{
    public function actionIndex()
    {
        require Yii::getAlias('@app/extensions/jdf.php');
        
        $now = [ date('j') ];
        
        $n = date('n');
        
        if ($n == 2 && date('j') == 28) {
            $now = [28, 29, 30, 31];   
        }
        
        $times = implode(',', $now);
        
        $virtualServers = Vps::find()->where("reset_at IN ($times)")->all();
        
        foreach ($virtualServers as $vps) {
            
            $a = Bandwidth::find()->where(['vps_id' => $vps->id])->orderBy('id DESC')->limit(1)->one();
		    $b = Bandwidth::find()->where(['vps_id' => $vps->id])->orderby('id DESC')->limit(1)->offset(1)->one();
		    
		    if ($a && $b) {
        	    $a->used = $a->pure_used = 0;
        	    $a->save(false);
        	    
        	    $b->used = $b->pure_used = 0;
        	    $b->save(false);
	        }
        }
    }
}
