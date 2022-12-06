<?php

namespace vanitokurason\orderlist\controllers;

use vanitokurason\orderlist\models\OrderSearch;
use yii\web\Controller;


class OrderController extends Controller
{
    public function actionIndex()
    {
        $status = $this->request->getQueryParam('status') ?? null;

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->get());
        return $this->render('order', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }
}
