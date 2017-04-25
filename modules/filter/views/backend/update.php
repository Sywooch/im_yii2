<?php

use yii\helpers\Html;

$this->title = 'Редактировать (Категории тренингов): ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории тренингов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="filter-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
