<?php

use yii\helpers\Html;

$this->title = 'Создание нового материала';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
    <h3><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
		'productItems' => $productItems,
		'actionItems' => $actionItems,
		'catalogItems' => $catalogItems,
		'features' => $features,
		'options' => $options,
    ]) ?>
</div>