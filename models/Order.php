<?php

namespace vanitokurason\orderlist\models;

use Yii;
use vanitokurason\orderlist\models\Service;
use vanitokurason\orderlist\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Order extends \yii\db\ActiveRecord
{
    private const MOD_MANUAL = 0;
    private const MOD_AUTO = 1;

    public const MOD_LIST = [
        self::MOD_MANUAL => 'Manual',
        self::MOD_AUTO => 'Auto'
    ];

    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'userName' => Yii::t('app', 'User'),
            'link' => Yii::t('app', 'Link'),
            'quantity' => Yii::t('app', 'Quantity'),
            'service_id' => Yii::t('app', 'Service ID'),
            'serviceName' => Yii::t('app', 'Service'),
            'statusName' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created'),
            'modeName' => Yii::t('app', 'Mode'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserName()
    {
        $model = $this->user;
        return $model?$model->first_name . ' ' . $model->last_name:'';
    }

    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    public function getServiceName()
    {
        $model = $this->service;
        return $model?$model->name:'';
    }
}