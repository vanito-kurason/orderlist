<?php

namespace vanitokurason\orderlist\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


class OrderSearch extends Order
{
    private const SEARCH_BY_ORDER_ID = 1;
    private const SEARCH_BY_LINK = 2;
    private const SEARCH_BY_USER_NAME = 3;

    public $userName;
    public $serviceName;
    public $modeName;
    public $statusName;

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
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();

        $query->joinWith(['user', 'service']);

        $query->andFilterWhere([
            'status' => $params['status'] ?? null,
            'mode' => $params['mode'] ?? null,
            'service_id' => $params['service'] ?? null
        ]);


        if (isset($params['search']) && isset($params['search-type'])) {
            $query = $this->applySearchParams($query, $params);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => 'SORT_DESC'
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    protected function applySearchParams(ActiveQuery $query, $params): ActiveQuery
    {
        if(isset($params['search-type'])) {
            switch ($params['search-type']) {
                case self::SEARCH_BY_ORDER_ID:
                    $query->andFilterWhere(['orders.id' => $params['search']]);
                    break;
                case self::SEARCH_BY_LINK:
                    $query->andFilterWhere(['like', 'link', $params['search']]);
                    break;
                case self::SEARCH_BY_USER_NAME:
                    $name = explode(' ', $params['search']);
                    if (count($name) == 2) {
                        $query->andFilterWhere(['in', 'first_name', $name]);
                        $query->andFilterWhere(['in', 'last_name', $name]);
                    } else {
                        $query->andFilterWhere(['like', 'first_name' . ' ' . 'last_name', $name]);
                    }
                    break;
            }
        }
        return $query;
    }
}
