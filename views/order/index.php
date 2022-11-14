<?php


use vanitokurason\orderlist\OrderlistAsset;
use vanitokurason\orderlist\models\Order;
use vanitokurason\orderlist\models\Service;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

OrderlistAsset::register($this);

if (isset(Yii::$app->request->queryParams)) {
    if (isset(Yii::$app->request->queryParams['status'])) {
        $currentStatus = Yii::$app->request->queryParams['status']; //save current status filter
    }

    if (isset(Yii::$app->request->queryParams['service_id'])) {
        $currentService = Yii::$app->request->queryParams['service_id']; //save current service filter
    }

    if (isset(Yii::$app->request->queryParams['mode'])) {
        $currentMode = Yii::$app->request->queryParams['mode']; //save current mode filter
    }

    if (isset(Yii::$app->request->queryParams['search'])) {
        $currentSearch = Yii::$app->request->queryParams['search'];
        $currentSearchType = Yii::$app->request->queryParams['searchType']; //save current search and searchType
    }
}

/** @var yii\web\View $this */
/** @var vanitokurason\orderlist\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= Url::toRoute('order/') ?>">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= isset($currentStatus)?'':'active' ?>">
            <a href="<?= Url::toRoute('order/') ?>">
                All orders
            </a>
        </li>
        <?php foreach($searchModel::$statusList as $key => $elem): ?>
                <li class="<?= (isset($currentStatus) && $currentStatus == $key)?'active':'' ?>">
                    <a href="<?= Url::toRoute("order/?status=$key") ?>">
                        <?= $elem ?>
                    </a>
                </li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action="/orderlist/order/" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <?php if(isset($currentStatus)) echo "<input type='hidden' name='status' value=$currentStatus>"; ?>
                    <span class="input-group-btn search-select-wrap">
                        <select class="form-control search-select" name="searchType">
                            <option value="1" selected="">Order ID</option>
                            <option value="2">Link</option>
                            <option value="3">Username</option>
                        </select>
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>
        </li>
    </ul>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Showing {begin} - {end} of {totalCount} items",
        'summaryOptions' => [
            'style' => [
                'text-align' => 'right'
            ]
        ],
        'columns' => [
            [
                'attribute'=> 'id',
                'filter' => false
            ],
            [
                'attribute' => 'userName',
                'label' => 'User',
                'filter' => false
            ],
            [
                'attribute' => 'link',
                'filter' => false
            ],
            [
                'attribute'=> 'quantity',
                'filter' => false
            ],
            [
                'attribute' => 'serviceName',
                'value' => 'serviceName',
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'service_id',
                        ArrayHelper::map(Service::find()->asArray()->all(), 'id', 'name'),
                        [
                            'class' => 'form-control form-control-sm',
                            'prompt' => 'All'
                        ])
            ],
            [
                'attribute' => 'status',
                'value' => 'statusName',
                'filter' => false
            ],
            [
                'attribute' => 'mode',
                'value' => 'modeName',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel,
                    'mode',
                    Order::$modeList,
                        [
                            'class' => 'form-control form-control-sm',
                            'prompt' => 'All',
                            'id' => 'none'
                        ])
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Created',
                'format' => ['date', 'php: Y-m-d H:i:s'],
                'filter' => false
            ]
        ],
        'layout' => "{items}\n{pager}{summary}"
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>