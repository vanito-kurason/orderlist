<?php

namespace vanitokurason\orderlist\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class OrderSearch extends Order
{
    public $userName;
    public $serviceName;
    public $modeName;
    public $statusName;

    public function rules()
    {
        return [
            [['id', 'user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link', 'userName', 'serviceName', 'statusName', 'modeName'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find()->joinWith(['user', 'service']);

        $query->andFilterWhere([
            'status' => $params['status'] ?? null,
            'mode' => $params['mode'] ?? null,
            'service_id' => $params['service'] ?? null
        ]);

        $query = $this->setSearchType($query, $params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => 'SORT_DESC'
                ]
            ]
        ]);

//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        return $dataProvider;
    }

    protected function setSearchType($query, $params)
    {
        if(isset($params['searchType'])) {
            switch ($params['searchType']) {
                case 1:
                    $query->andFilterWhere(['orders.id' => $params['search']]);
                    break;
                case 2:
                    $query->andFilterWhere(['like', 'link', $params['search']]);
                    break;
                case 3:
                    $name = explode(' ', $params['search']);
                    if (count($name) == 2) {
                        $query->andFilterWhere(['in', 'first_name', $name]);
                        $query->andFilterWhere(['in', 'last_name', $name]);
                    } else {
                        $query->andFilterWhere(['like', 'first_name', $name]);
                        $query->orFilterWhere(['like', 'last_name', $name]);
                    }
                    break;
            }
        }

        return $query;
    }
}
