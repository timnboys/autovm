<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

use app\models\Vps;
use app\models\User;
use app\models\Setting;
use app\models\UserLogin;
use app\models\VpsAction;
use app\models\Bandwidth;
use app\modules\admin\filters\OnlyAdminFilter;
use app\modules\admin\models\forms\SettingForm;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            OnlyAdminFilter::className(),
        ];
    }
    
    public function actionIndex()
    {
        $stats = new \stdClass;
        
        $stats->totalVps = Vps::find()->count();
        $stats->totalUsers = User::find()->count();
        $stats->vpsActions = VpsAction::find()->orderBy('id DESC')->limit(6)->all();
		$stats->bandwidth = Bandwidth::find()->sum('pure_used');
		
		$stats->logins = UserLogin::find()->orderBy('id DESC')->limit(8)->all();
        
        return $this->render('index', compact('stats'));
    }
    
    public function actionLogin()
    {
        $logins = UserLogin::find()->orderBy('id DESC');
        
        $count = clone $logins;
        $pages = new Pagination(['totalCount' => $count->count()]);
        $pages->setPageSize(8);
        
        $logins = $logins->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('login', [
            'logins' => $logins,
            'pages' => $pages,
        ]);
    }
    
    public function actionUpdate()
    {
        while (true) {
            
            $result = $this->update();
            
            if ($result === false) {
                break;
            }
            
            sleep(1);

        }
        
        return $this->redirect(['setting']);
    }
    
    public function update()
    {
        $current = @file_get_contents(Yii::getAlias('@app/config/version.php'));
        $new = $current+1;
        
        $path = "http://update.autovm.net/news/$new.zip";
        $newPath = Yii::getAlias("@app/runtime/update/$new.zip");
        
        $data = @file_get_contents($path);
        @file_put_contents($newPath, $data);
        
        if ($data && file_exists($newPath)) {
        
            $zip = new \ZipArchive();
            
            $zip->open($newPath);
            
            $db = $zip->getFromName('db.sql');
            
            if ($db) {
                $parts = explode(';', $db);
                
                try {
                    foreach ($parts as $part) {
                        Yii::$app->db->createCommand($part)->execute();   
                    }
                } catch (\Exception $e) {
                    
                }
            }
            
            $zip->extractTo(Yii::getAlias('@app/'));            
            
            $zip->close();
            
            @file_put_contents(Yii::getAlias('@app/config/version.php'), $new);
            
            return true;
        }
        
        return false;
    }
    
    public function actionSetting()
    {
        $model = new SettingForm;
        
        $model->setAttributes(Yii::$app->setting->all());
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->getAttributes() as $key => $value) {
                $setting = Setting::find()->where(['key' => $key])->one();
                
                if ($setting) {
                    $setting->value = $value;
                    $setting->save(false);  
                }
            }
            
            return $this->refresh();
        } 
        
        $current = @file_get_contents(Yii::getAlias('@app/config/version.php'));
        $new = $current + 1;

        $path = "http://update.autovm.net/news/$new.zip";

        $content = @file_get_contents($path);

        if ($content) {
            $needUpdate = true;
        } else {
            $needUpdate = false;
        }
        
        return $this->render('setting', compact('model', 'current', 'needUpdate'));
    }
}