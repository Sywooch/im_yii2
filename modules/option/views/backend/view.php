<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->option;
$this->params['breadcrumbs'][] = ['label' => 'Опции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-view">

    <!--<h3><?//= Html::encode($this->title) ?></h3>-->

    <!--<p>
        <?//= Html::a('Редактировать', ['/admin/option/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Удалить', ['/admin/option/delete', 'id' => $model->id], [
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
			'code',
			'price',
        ],
    ]) ?>
</div>
