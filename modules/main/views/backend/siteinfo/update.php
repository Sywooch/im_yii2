<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */

$this->title = 'Редактирование общей информации сайта: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Инфо', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="siteinfo-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
