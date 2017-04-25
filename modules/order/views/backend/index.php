<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\components\widgets\backend\grid\EditColumn;
use app\modules\order\Module;
use app\modules\order\models\Order;
use kartik\date\DatePicker;
$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">
    <h3><?= Html::encode($this->title) ?></h3>
	<p>
		<?//= Html::a('Создать новый заказ', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
	</p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'id',
			['class' => 'yii\grid\CheckboxColumn'],
			[
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'date_from',
					'attribute2' => 'date_to',
					'type' => DatePicker::TYPE_RANGE,
					'separator' => '-',
					'pluginOptions' => ['format' => 'yyyy-mm-dd']
				]),
				'attribute' => 'date',
				'format' => 'date',
			],
			'name',
			'phone',
            'email',
			[
				'filter' => Order::getStatusArray(),
				'attribute' => 'status',
				'format' => 'raw',
				'value' => function ($model, $key, $index, $column) {
					$value = $model->{$column->attribute};
					switch ($value) {
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
					$html = '<p class="text-right"><span class="label label-'.$class.'">'.Html::encode($model->getStatusName()).'</span>';
					return $value === null ? $column->grid->emptyCell : $html;
				}
			],
			[
				'filter' => Order::getTypeArray(),
				'attribute' => 'type',
				'format' => 'raw',
				'value' => function ($model, $key, $index, $column) {
					$value = $model->{$column->attribute};
					$html = '<p class="text-right"><span class="label label-success">'.Html::encode($model->getTypeName()).'</span>';
					return $value === null ? $column->grid->emptyCell : $html;
				}
			],
			'total',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '<p class="text-right">{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}</p>'
			],
		],
	]); ?>
	<?= Html::endForm()?>
</div>