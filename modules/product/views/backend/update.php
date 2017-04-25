<?php

use yii\helpers\Html;

$this->title = 'Редактировать (Товары): ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="product-update">
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