<?php

use yii\helpers\Html;

$this->title = 'Создание нового материала';
$this->params['breadcrumbs'][] = ['label' => 'Категории тренингов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filter-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
