<?php

namespace vanitokurason\orderlist\controllers;

use vanitokurason\orderlist\models\OrderSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;


class OrderController extends Controller
{
    public function actionIndex()
    {
        $status = $this->request->getQueryParam('status') ?? null;
        $mode = $this->request->getQueryParam('mode') ?? null;
        $search = $this->request->getQueryParam('search') ?? null;
        $searchType = $this->request->getQueryParam('search-type') ?? null;

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->getQueryParams());
        $pages = $dataProvider->pagination;
        return $this->render('order', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            'mode' => $mode,
            'search' => $search,
            'searchType' => $searchType,
            'pages' => $pages
        ]);
    }
}
