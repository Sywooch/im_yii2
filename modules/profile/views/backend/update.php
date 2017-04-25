<?php

use yii\helpers\Html;

$this->title = 'Редактировать (Профиль): ' . ' ' . $model->lastname . ' ' . $model->name . ' ' . $model->phathername;
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lastname . ' ' . $model->name . ' ' . $model->phathername, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="portfolio-update">
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
