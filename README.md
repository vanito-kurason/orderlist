Yii2 module
===========
Module for orders listing

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist vanito-kurason/yii2-orderlist "*"
```

or add

```
"vanito-kurason/yii2-orderlist": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Add to main.config:

```php
'modules' => [
    'orderlist' => [
        'class' =>’vanitokurason\orderlist\Orderlist'
    ]
]
```


Once the extension is installed, simply use it in your code by  :

```php
<?= \vanitokurason\orderlist\AutoloadExample::widget(); ?>
```


To enable caching add at config db.php:

```php
return [
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 120,
    'schemaCache' => 'cache',
];
```

