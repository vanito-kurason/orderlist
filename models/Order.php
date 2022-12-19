<?php

namespace vanitokurason\orderlist\models;

use Yii;
use vanitokurason\orderlist\models\Service;
use vanitokurason\orderlist\models\User;

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