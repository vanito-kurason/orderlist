<?php
namespace vanitokurason\orderlist\form;

use vanitokurason\orderlist\models\Order;

class SearchForm extends Order {
    public function rules()
    {
        return [
            [['service_id'], 'integer', 'max' => 17, 'min' => 1],
            [['status'], 'integer', 'max' => 4, 'min' => 0],
            [['mode'], 'integer', 'max' => 1, 'min' => 0],
            [['link'], 'string', 'max' => 300],
        ];
    }
}