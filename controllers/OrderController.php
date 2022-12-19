<?php
namespace vanitokurason\orderlist\controllers;

use vanitokurason\orderlist\models\OrderSearch;
use vanitokurason\orderlist\form\SearchForm;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;


class OrderController extends Controller
{
    public function actionIndex()
    {
        $searchForm = new SearchForm();
        $searchForm->load(Yii::$app->request->get(), '');
        if (!$searchForm->validate()) {
            $errors = $searchForm->errors;
            $message = '';
            foreach ($errors as $error) {
                $message .= $error[0] . "\n";
            }
            throw new BadRequestHttpException($message);
        }

        $status = Yii::$app->request->get('status') ?? null;
        $mode = Yii::$app->request->get('mode') ?? null;
        $search = Yii::$app->request->get('search') ?? null;
        $searchType = Yii::$app->request->get('searchType') ?? null;
        $service_id = Yii::$app->request->get('service_id') ?? null;

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
            'service_id' => $service_id,
            'pages' => $pages
        ]);
    }
}