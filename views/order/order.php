<?php
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

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
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') !== null ? '' : 'active' ?>"><a href="<?= Url::to('/orderlist') ?>">All orders</a></li>
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') === '0' ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/?status=0') ?>">Pending</a></li>
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') == 1 ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/?status=1') ?>">In progress</a></li>
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') == 2 ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/?status=2') ?>">Completed</a></li>
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') == 3 ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/?status=3') ?>">Canceled</a></li>
        <li class="<?= Yii::$app->getRequest()->getQueryParam('status') == 4 ? 'active' : '' ?>"><a href="<?= Url::to('/orderlist/?status=4') ?>">Error</a></li>
        <li class="pull-right custom-search">
            <form class="form-inline" action="/admin/orders" method="get">
                <div class="input-group">
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
                        <li class="active"><a href="">All (894931)</a></li>
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
                        <li class="active"><a href="">All</a></li>
                        <li><a href="">Manual</a></li>
                        <li><a href="">Auto</a></li>
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
                <td><?= $item['user_id'] ?></td>
                <td class="link"><?= $item['link'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['service_id'] ?></td>
                <td><?= $item['status'] ?></td>
                <td><?= $item['mode'] ?></td>
                <td><?= $item['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        <!--    <tr>-->
        <!--      <td>558931</td>-->
        <!--      <td>waliullah</td>-->
        <!--      <td class="link">/p/BMRSv4FDevy/</td>-->
        <!--      <td>3000</td>-->
        <!--      <td class="service">-->
        <!--        <span class="label-id">213</span>Likes-->
        <!--      </td>-->
        <!--      <td>Pending</td>-->
        <!--      <td>Manual</td>-->
        <!--      <td><span class="nowrap">2016-01-27</span><span class="nowrap">15:13:52</span></td>-->
        <!--    </tr>-->
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">

            <nav>
                <ul class="pagination">
                    <li class="disabled"><a href="" aria-label="Previous">&laquo;</a></li>
                    <li class="active"><a href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href="">5</a></li>
                    <li><a href="">6</a></li>
                    <li><a href="">7</a></li>
                    <li><a href="">8</a></li>
                    <li><a href="">9</a></li>
                    <li><a href="">10</a></li>
                    <li><a href="" aria-label="Next">&raquo;</a></li>
                </ul>
            </nav>

        </div>
        <div class="col-sm-4 pagination-counters">
            1 to 100 of 3263
        </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
<html>