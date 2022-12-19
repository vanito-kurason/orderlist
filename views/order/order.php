<?php
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\widgets\LinkPager;
use vanitokurason\orderlist\models\OrderStatus;
use vanitokurason\orderlist\models\Order;
use yii\grid\GridView;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
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
                <li class="active"><a href="<?= Url::to('/orderlist') ?>">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= $status === null ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/') ?>">All orders</a></li>
        <?php foreach (OrderStatus::NAMING as $key => $status_name): ?>
            <li class="<?= $status === "$key" ? 'active' : '' ?>"><a href="<?= Url::to(['/orderlist/', 'status' => $key]) ?>"><?= $status_name ?></a></li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action='/orderlist/' method="get">
                <div class="input-group">
                    <?php if(isset($status)) echo "<input type='hidden' name='status' value=$status>"; ?>
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
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
    <table class="table order-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Service
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="active"><a href="<?= Url::to(['/orderlist/', 'mode' => $mode, 'status' => $status]) ?>">All (<?= $dataProvider->getTotalCount() ?>)</a></li>
                        <li><a href=""><span class="label-id">214</span>  Real Views</a></li>
                        <li><a href=""><span class="label-id">215</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">10</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">217</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">221</span> Followers</a></li>
                        <li><a href=""><span class="label-id">224</span> Groups Join</a></li>
                        <li><a href=""><span class="label-id">230</span> Website Likes</a></li>
                    </ul>
                </div>
            </th>
            <th>Status</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Mode
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="<?= is_null($mode) ? 'active' : '' ?>">
                            <a href="<?= Url::to(['/orderlist/',
                                'mode' => null,
                                'status' => $status,
                                'search' => $search,
                                'search-type' => $searchType
                            ]) ?>">All</a>
                        </li>
                        <?php foreach (Order::MOD_LIST as $key => $mod): ?>
                            <li class="<?= $mode === "$key" ? 'active' : '' ?>">
                                <a href="<?= Url::to(['/orderlist/',
                                    'mode' => $key,
                                    'status' => $status,
                                    'search' => $search,
                                    'search-type' => $searchType
                                ]) ?>">
                                    <?= $mod ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($dataProvider->getModels() as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item->getUserName() ?></td>
                <td class="link"><?= $item['link'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item->getServiceName() ?></td>
                <td><?= OrderStatus::NAMING[$item['status']] ?></td>
                <td><?= Order::MOD_LIST[$item['mode']] ?></td>
                <td>
                    <span class="nowrap"><?= date('Y-m-d', $item['created_at']) ?></span>
                    <span class="nowrap"><?= date('H-I-s', $item['created_at']) ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
        <!--      <td class="service">-->
        <!--        <span class="label-id">213</span>Likes-->
        <!--      </td>-->
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">
            <?=
            LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]);
            ?>
        </div>
        <div class="col-sm-4 pagination-counters">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{summary}',
                'summary' => $dataProvider->pagination->totalCount > $dataProvider->pagination->pageSize ?
                    "Showing {begin} - {end} of {totalCount} orders" :
                    "{totalCount} orders"
            ]); ?>
        </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
<html>