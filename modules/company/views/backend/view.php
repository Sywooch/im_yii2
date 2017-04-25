<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->company;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <!--<h3><?//= Html::encode($this->title) ?></h3>-->

    <!--<p>
        <?//= Html::a('Редактировать', ['/admin/company/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Удалить', ['/admin/company/delete', 'id' => $model->id], [
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
			'company',
			'inn',
			'address',
			'email',
			'phone',
			'fax',
			'bankname',
			'bik',
			'kpp',
			'rs',
			'ks',
			'comment',
        ],
    ]) ?>
</div>
