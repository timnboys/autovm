<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

use app\models\Iso;
use app\modules\admin\filters\OnlyAdminFilter;
use yii\data\ActiveDataProvider;

class IsoController extends Controller
{
    public function behaviors()
    {
        return [
            OnlyAdminFilter::className(),
        ];
    }
    
    public function actionIndex()
    {
        $items = Iso::find()->orderBy('id DESC');
        
        $dataProvider = new ActiveDataProvider([
              'query' => $items,
              'pagination' => [
                'pageSize' => 10,
              ],
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Iso;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Your new iso has been created'));
				
                return $this->refresh();
            }
        }
        
        return $this->render('create', compact('model'));
    }
    
    public function actionEdit($id)
    {
        $model = Iso::findOne($id);
        
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Not found anything'));
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Iso has been edited'));
				
                return $this->refresh();
            }
        }
        
        return $this->render('edit', compact('model'));
    }
    
    public function actionDelete()
    {
        if (($data = Yii::$app->request->post('data')) && is_array($data)) {
            foreach ($data as $id) {
                Iso::findOne($id)->delete();
            }
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}