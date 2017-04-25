<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\order\Module;

$this->title = 'Заказ №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

switch ($model->status) {
	case 0:
		$class = 'warning';
		break;
	case 1:
		$class = 'success';
		break;
	case 2:
		$class = 'default';
	default:
		$class = 'default';
};
?>
<div class="order-view">
    <h3><?= Html::encode($this->title) ?></h3>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'date',
			'name',
			'phone',
            'email',
            'address',
            'city',
			'text',
			[
				'label' => 'Способ доставки',
				'format' => 'html',
				'value' => '<p class="text-left"><span class="label label-success">'.Html::encode($model->getShippingName()).'</span>',
			],
            [
				'label' => 'Способ оплаты',
				'format' => 'html',
				'value' => '<p class="text-left"><span class="label label-success">'.Html::encode($model->getPaymentName()).'</span>',
			],
			[
				'label' => 'Состояние заказа',
				'format' => 'html',
				'value' => '<p class="text-left"><span class="label label-'.$class.'">'.Html::encode($model->getStatusName()).'</span>',
			],
			[
				'label' => 'Тип товара',
				'format' => 'html',
				'value' => '<p class="text-left"><span class="label label-default">'.Html::encode($model->getTypeName()).'</span>',
			],
			'total',
        ],
    ]) ?>
</div>
