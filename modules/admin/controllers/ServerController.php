<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

use app\models\Os;
use app\models\Server;
use app\models\Datastore;
use app\modules\admin\filters\OnlyAdminFilter;
use app\models\searchs\searchServer;

use app\extensions\Api;

class ServerController extends Controller
{
    public function behaviors()
    {
        return [
            OnlyAdminFilter::className(),
        ];
    }
    
    public function actionIndex()
    {   
        $searchModel = new searchServer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)
    {
        $server = Server::findOne($id);

        if (!$server) {
            throw new NotFoundHttpException;
        }
        
        $connect = $e = $dist = $info = $cpu = $license = false;
        
        $operationSystems = Os::find()->all();

        $dists = [];

        foreach ($operationSystems as $os) {
            $dists[] = $os->type;
        }

        $dists = implode(',', $dists);

    	$data = ['server' => $server->getAttributes(), 'dists' => $dists];
    	
    	$api = new Api;
    	
    	$api->setTimeout(30);
    	
    	$api->setUrl(Yii::$app->setting->api_url);
    	$api->setData($data);
    	
    	$result = $api->request(Api::ACTION_CHECK);

    	# connection status
    	if ($result) {
    	    $connect = true;
    	}

        if (!empty($result->e)) {
            $e = $result->e;
        }

        if (!empty($result->dist)) {
            $dist = $result->dist;
        }

        # server status
        if (!empty($result->data)) {
            $info = explode(',', $result->data);
        }
        
        if (!empty($result->data2)) {
            $cpu = $result->data2;
        }
 
        # license status
        $api->setData(['license' => $server->license]);
        
        $license = $api->request(Api::ACTION_INFO);

        return $this->render('view', compact('e', 'dist', 'server', 'connect', 'info', 'cpu', 'license'));
    }
    
    public function actionCreate()
    {
        $model = new Server;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Your new server has been created'));
				
                return $this->refresh();
            }
        }
        
        return $this->render('create', compact('model'));
    }
    
    public function actionEdit($id)
    {
        $model = Server::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Not found anything'));
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Server has been edited'));
				
                return $this->refresh();
            }
        }
        
        return $this->render('edit', compact('model'));
    }
    
    public function actionDelete()
    {
        if (($data = Yii::$app->request->post('data')) && is_array($data)) {
            foreach ($data as $id) {
                Server::findOne($id)->delete();
            }
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTest($ip)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $url = 'https://server1.autovm.info/web/index.php';
        $url .= "/api/test/test?ip=$ip";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);
curl_close($ch);

        $data = json_decode($result);

        if (empty($data->ok) || !$data->ok) {
            return ['ok' => false];
        }

        return ['ok' => true, 'secret' => $data->secret];
    }
}