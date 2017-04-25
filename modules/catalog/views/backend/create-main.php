<?php

use yii\helpers\Html;

$this->title = 'Создание общего материала модуля';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-create">
    <h3><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form-main', [
        'model' => $model,
    ]) ?>
</div>