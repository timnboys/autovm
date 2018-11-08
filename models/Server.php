<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

use app\extensions\Api as eApi;

/**
 * This is the model class for table "server".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $ip
 * @property integer $port
 * @property string $username
 * @property string $password
 * @property string $license
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Datastore[] $datastores
 * @property Ip[] $ips
 * @property Vps[] $vps
 */
class Server extends \yii\db\ActiveRecord
{
    #public function afterFind()
    #{
    #    $this->password = Yii::$app->security->decryptByPassword(base64_decode($this->password), Yii::$app->params['secret']);
    #}
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'server';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'name', 'port', 'username', 'password', 'license'], 'required'],
            [['version'], 'in', 'range' => self::getVersionList()],
            [['parent_id', 'port', 'created_at', 'updated_at', 'version'], 'integer'],
            [['ip'], 'string', 'max' => 45],
			[['license'], 'string', 'max' => 16],
			[['password'], 'string'],
            [['name', 'username', 'vcenter_ip', 'vcenter_username', 'vcenter_password', 'network', 'second_network'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'ip' => Yii::t('app', 'Ip'),
            'port' => Yii::t('app', 'Port'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'vcenter_ip' => Yii::t('app', 'Vcenter Ip'),
            'vcenter_username' => Yii::t('app', 'Vcenter Username'),
            'vcenter_password' => Yii::t('app', 'Vcenter Password'),
            'network' => Yii::t('app', 'Network'),
            'second_network' => Yii::t('app', 'Second Network'),
            'version' => Yii::t('app', 'Esxi Version'),
			'license' => Yii::t('app', 'License'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatastores()
    {
        return $this->hasMany(Datastore::className(), ['server_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIps()
    {
        return $this->hasMany(Ip::className(), ['server_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVps()
    {
        return $this->hasMany(Vps::className(), ['server_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\ServerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\ServerQuery(get_called_class());
    }
    
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['parent_id', 'name', 'ip', 'port', 'username', 'password', 'vcenter_ip', 'vcenter_username', 'vcenter_password', 'network', 'second_network', 'version', 'license'],
        ];
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function beforeSave($insert)
    {
    	if ($this->password != $this->getOldAttribute('password')) {
    	
    		$api = new eApi;
    		
    		$api->setUrl(Yii::$app->setting->api_url);
    		$api->setData(['password' => $this->password]);
    		
    		$result = $api->request(eApi::ACTION_ENCRYPT);
    		
    		$this->password = $result->password;
    	}
    	
    	if ($this->vcenter_password != $this->getOldAttribute('vcenter_password') && !empty($this->vcenter_password)) {
    	
    		$api = new eApi;
    		
    		$api->setUrl(Yii::$app->setting->api_url);
    		$api->setData(['password' => $this->vcenter_password]);
    		
    		$result = $api->request(eApi::ACTION_ENCRYPT);
    		
    		$this->vcenter_password = $result->password;
    	}
    	
    	return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            
            $api = new eApi;

            $api->setUrl(Yii::$app->setting->api_url);
            $api->setData(['server' => $this->getAttributes()]);

            $result = $api->request(eApi::ACTION_DS);

            if (!empty($result->data)) {
                
                $parts = explode('&', trim($result->data, '&'));
                $parts = array_chunk($parts, 3);
                
                foreach ($parts as $part) {
                    $ds = new Datastore;
                    $ds->server_id = $this->id;
                    $ds->uuid = $part[0];
                    $ds->value = $part[1];
                    $ds->space = $part[2];
                    $ds->is_default = Datastore::IS_NOT_DEFAULT;
                    $ds->save(false);
                }
                
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    #public function beforeSave($insert)
    #{
    #    $this->password = base64_encode(Yii::$app->security->encryptByPassword($this->password, Yii::$app->params['secret']));
    #    return parent::beforeSave($insert);
    #}
    
    public static function getVersionList()
    {
        return array_combine(range(8, 14), range(8, 14));
    }
    
    public static function getListData()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
