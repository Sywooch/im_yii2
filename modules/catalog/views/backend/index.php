<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

use app\components\widgets\backend\grid\StatusColumn;
use app\components\widgets\backend\grid\EditColumn;
use app\components\widgets\SelectTreeItems;
use app\modules\catalog\Module;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-index">
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
					<td><?= $mainModel->short_title ?></td>
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
	
	<?php $form = ActiveForm::begin(['action' => '/admin/' . Module::getInstance()->id . '/create-fast']); ?>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="form-group field-catalog-catalogsArray required">
				<label class="control-label" for="catalog-catalogArray">Родительский материал</label>
				<select class="form-control" name="Catalog[catalogArray]">
					<option value="">.. нет ..</option>
					<?= SelectTreeItems::widget([
						'data' => $selectItems,
						'model' => $newModel,
						'childRelation' => 'children',
						'parentField' => 'parent_id',
						'isMany' => true, // true - если виджет используется в модуле catalog, false - если в модуле menu (обусловленно особенностью данной разработки)
					]); ?>
				</select>
				<div class="help-block"></div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<?= $form->field($newModel, 'short_title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="form-group pd-top-25">
				<?= Html::submitButton('Быстро создать новую запись', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	<hr>
	<p>
		<?= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
	</p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\CheckboxColumn'],
			[
				'class' => EditColumn::className(),
				'attribute' => 'short_title',
				'marginLeft' => 50, // "Сдвиг" px вложенных элементов
				'level' => true, // Включаем "сдвиг" в зависимости от уровня вложенности
				'style' => 'middle center',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'alias',
				'style' => 'middle center',
			],
			[
				'class' => EditColumn::className(),
				'attribute' => 'weight',
				'fieldType' => 'number',
				'style' => 'small right',
			],
			[
				'class' => StatusColumn::className(),
				'attribute' => 'status',
			],
			[	
				'class' => 'yii\grid\ActionColumn', 
				'template' => '<p class="text-right">{update}&nbsp;&nbsp;{delete}</p>'
			]
		],
	]); ?>
	<?= Html::endForm()?>
</div>