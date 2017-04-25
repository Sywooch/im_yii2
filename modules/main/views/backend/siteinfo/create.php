<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */

$this->title = 'Создание нового материала';
$this->params['breadcrumbs'][] = ['label' => 'Инфо', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siteinfo-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
