<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->feature;
$this->params['breadcrumbs'][] = ['label' => 'Характеристики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feature-view">

    <!--<h3><?//= Html::encode($this->title) ?></h3>-->

    <!--<p>
        <?//= Html::a('Редактировать', ['/admin/feature/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Удалить', ['/admin/feature/delete', 'id' => $model->id], [
        //    'class' => 'btn btn-danger',
        //    'data' => [
        //        'confirm' => 'Вы уверены, что хотите удалить?',
        //        'method' => 'post',
        //    ],
        //]) ?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'name',
			'value',
        ],
    ]) ?>
</div>
