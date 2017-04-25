<?php
use yii\helpers\Html;
$this->title = 'Создание нового материала';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-create">
    <h3><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
		'selectItems' => $selectItems,
    ]) ?>
</div>