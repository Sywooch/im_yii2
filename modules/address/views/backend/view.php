<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Адреса', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-view">

    <!--<h3><?//= Html::encode($this->title) ?></h3>-->

    <!--<p>
        <?//= Html::a('Редактировать', ['/admin/address/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Удалить', ['/admin/address/delete', 'id' => $model->id], [
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
			'title',
			'country',
			'zone',
			'city',
			'postcode',
			'address',
			'postname',
			'postlastname',
			'postphathername',
			'comment',
        ],
    ]) ?>
</div>
