<?php

/** @var string $content */

use vanitokurason\orderlist\OrderlistAsset;

OrderlistAsset::register($this);
$this->registerCsrfMetaTags();
?>

<?php $this->beginPage() ?>
<?= $content ?>
<?php $this->endPage() ?>