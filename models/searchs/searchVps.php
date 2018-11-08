<?php

namespace app\models\searchs;


use yii\data\ActiveDataProvider;
use yii\base\Model;
use app\models\Vps;

class searchVps extends Vps
{
    public $ip;
    public $email;
    
    public function rules()
    {
        return [
            [['ip', 'email'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Vps::find()->orderBy('id DESC');
        
        $query->joinWith(['ip', 'email']);
        
        $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                'pageSize' => 10,
              ],
        ]);
        
        if (!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'ip.ip', $this->ip])
        ->andFilterWhere(['like', 'user_email.email', $this->email]);
        
        return $dataProvider;
    }
}