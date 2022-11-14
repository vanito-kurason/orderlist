<?php

namespace vanitokurason\orderlist;

use yii\web\AssetBundle;

class OrderlistAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@vanitokurason/orderlist/assets/';
        $this->baseUrl = '@vanitokurason/orderlist/';
        parent::init();
    }

    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
