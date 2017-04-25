<?php

use yii\helpers\Html;

$this->title = 'Редактирование параметра: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="setting-update">
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
