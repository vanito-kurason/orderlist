<?php
namespace vanitokurason\orderlist\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class OrderSearch extends Order
{
    private const SEARCH_BY_ORDER_ID = 1;
    private const SEARCH_BY_LINK = 2;
    private const SEARCH_BY_USER_NAME = 3;

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();

        $query->joinWith(['user','service']);

        $query->andFilterWhere([
            'status' => $params['status'] ?? null,
            'mode' => $params['mode'] ?? null,
            'service_id' => $params['service_id'] ?? null
        ]);

        if (isset($params['search']) && isset($params['searchType'])) {
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
            return $dataProvider;
        }

        return $dataProvider;
    }

    protected function applySearchParams(ActiveQuery $query, $params): ActiveQuery
    {
        if ($params['searchType'] == self::SEARCH_BY_ORDER_ID) {
            return $query->andFilterWhere(['orders.id' => $params['search']]);
        };

        if ($params['searchType'] == self::SEARCH_BY_LINK) {
            return $query->andFilterWhere(['like', 'link', $params['search']]);
        };

        if ($params['searchType'] == self::SEARCH_BY_USER_NAME) {

            $name = explode(' ', $params['search']);

            if (count($name) == 2) {
                $query->andFilterWhere(['in', 'first_name', $name]);
                $query->andFilterWhere(['in', 'last_name', $name]);
                return $query;
            } else {
                $listOfFirstNames = User::find()->select('first_name')->asArray()->all();
                $firstName = [];
                foreach ($listOfFirstNames as $one) {
                    $firstName[] = $one['first_name'];
                }
                if (in_array($name[0], $firstName)) {
                    return $query->andFilterWhere(['like', 'first_name', $name]);
                } else {
                    return $query->andFilterWhere(['like', 'last_name', $name]);
                }
            }
        }
    }
}
