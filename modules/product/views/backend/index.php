<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\widgets\backend\grid\StatusColumn;
use app\components\widgets\backend\grid\IsNotColumn;
use app\components\widgets\backend\grid\EditColumn;

use app\modules\file\components\Img;
use app\modules\product\Module;
use kartik\date\DatePicker;

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <h3><?= Html::encode($this->title) ?></h3>
	
	<?php if($mainModel):?>
		<hr>
		<h4>Общий контент модуля</h4>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Наименование</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $mainModel->title ?></td>
					<td>
						<p class="text-right">
							<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-main', 'id' => $mainModel->id], ['title' => 'Редактировать']) ?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	<?php else:?>
		<p>
			<?= Html::a('Создать общий контент модуля', ['create-main'], ['class' => 'btn btn-success']) ?>
		</p>
	<?php endif;?>

	<p>
		<?= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?><br>
	</p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\CheckboxColumn'],
			[
				'attribute' => 'imageFile',
				'format' => 'html',
				'value' => function ($model, $key, $index, $column) {
					if($model->thumb){
						return '<img src="'.Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename).'" class="image-icon">';
					}
				}
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'title',
			],
			'code',
			[
				'class' => EditColumn::className(),
				'attribute' => 'sku',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'old_price',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'price',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'alias',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'weight',
				'fieldType' => 'number',
				'style' => 'small right',
			],
			[
				'class' => IsNotColumn::className(),
				'attribute' => 'is_not',
			],
			[
				'class' => StatusColumn::className(),
				'attribute' => 'status',
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '<p class="text-right">{update}&nbsp;&nbsp;{delete}</p>'
			],
		],
	]); ?>
	<?= Html::endForm()?>
</div>