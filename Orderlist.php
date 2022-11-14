<?php

namespace vanitokurason\orderlist;

class Orderlist extends \yii\base\Module
{

    public $controllerNamespace = 'vanitokurason\orderlist\controllers';

    public function init()
    {
        parent::init();
        $this->layout = 'mainModule';
    }

}
