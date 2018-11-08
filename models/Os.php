<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "os".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $operation_system
 * @property string $username
 * @property string $password
 * @property string $adapter
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vps[] $vps
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'adapter'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'type', 'username', 'password', 'operation_system', 'adapter'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
			'username' => Yii::t('app', 'Username'),
			'password' => Yii::t('app', 'Password'),
            'adapter' => Yii::t('app', 'Adapter'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'operation_system' => Yii::t('app', 'Operation System'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVps()
    {
        return $this->hasMany(Vps::className(), ['os_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\OsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\OsQuery(get_called_class());
    }

    public static function getOperationSystem()
    {
     	$list =  array(
                'windows 2003 32 bit',
                'windows 2008 32 bit',
                'windows 2008 64 bit',
                'windows 2012 64 bit',
                'windows 2016 64 bit',
                'ubuntu 16.04 32 bit',
                'ubuntu 16.04 64 bit',
                'centos 7 64 bit',
                'centos 6.8 32 bit',
                'centos 6.8 64 bit',                
                'debian 8.5 32 bit',
                'debian 8.5 64 bit',
                'mikrotik'
            );

	return array_combine($list, $list);
    }
    
    public static function getAdapters()
    {
        return [
            'e1000' => 'e1000',  
            'vmxnet3' => 'vmxnet3',  
            'e1000e' => 'e1000e',  
        ];
    }
    
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'type', 'username', 'password', 'adapter'],
        ];
    }
        
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
