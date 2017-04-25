<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use app\modules\menu\models\Menu;

use yii\grid\GridView;
use app\components\widgets\backend\grid\StatusColumn;
use app\components\widgets\backend\grid\EditColumn;
use app\components\widgets\SelectTreeItems;
use app\modules\menu\Module;

use yii\widgets\ActiveForm;

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <h3><?= Html::encode($this->title) ?></h3>

	<hr>
	<?php $form = ActiveForm::begin(['action' => '/admin/' . Module::getInstance()->id . '/create']); ?>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-2">
			<?= $form->field($newModel, 'type_id')->dropDownList(Menu::getTypeMenuArray(), ['options' => [$newModel->type_id => ['class' => 'selected']]]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-2">
			<?//= $form->field($newModel, 'parent_id')->dropDownList(ArrayHelper::map($parentItems, 'id', 'title'), ['prompt' => '.. нет ..', 'options' => [$newModel->parent_id => ['class' => 'selected']]]) ?>
			<div class="form-group field-menu-parent_id required">
				<label class="control-label" for="menu-parent_id">Родительский элемент</label>
				<select class="form-control" name="Menu[parent_id]">
					<option value="">.. нет ..</option>
					<?= SelectTreeItems::widget([
						'data' => $selectItems,
						'model' => $newModel,
						'parentField' => 'parent_id',
						'isMany' => false, // true - если виджет используется в модуле catalog, false - если в модуле menu (обусловленно особенностью данной разработки)
					]); ?>
				</select>
				<div class="help-block"></div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-2">
			<?= $form->field($newModel, 'title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-2">
			<?= $form->field($newModel, 'url')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-2">
			<?= $form->field($newModel, 'icon')->dropDownList(Menu::getSocialIconArray(), ['prompt' => '.. нет ..']) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-2">
			<div class="form-group pd-top-25">
				<?= Html::submitButton('Создать новую запись', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	<hr>

    <p>
		<?//= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?><br>
    </p>

	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
	
	<?php if($data AND count($data) > 0):?>
		<?php foreach($data as $type_id => $menu):?>
		
			<h4><?= $newModel->getTypeMenuName($type_id) ?></h4>
			
			<?= GridView::widget([
				'dataProvider' => $menu,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					['class' => 'yii\grid\CheckboxColumn'],
					[
						'class' => EditColumn::className(),
						'attribute' => 'title',
						'marginLeft' => 50, // "Сдвиг" px вложенных элементов
						'level' => true, // Включаем "сдвиг" в зависимости от уровня вложенности
						'style' => 'middle center',
					],
					'icon',
					[
						'class' => EditColumn::className(),
						'attribute' => 'url',
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
			
			<?/* = TreeGrid::widget([
				'dataProvider' => $menu,
				'keyColumnName' => 'id',
				'parentColumnName' => 'parent_id',
				'parentRootValue' => 0, //first parentId value
				'pluginOptions' => [
					'initialState' => 'collapsed',
				],
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					['class' => 'yii\grid\CheckboxColumn'],
					[
						'class' => EditColumn::className(),
						'attribute' => 'title',
						'style' => 'middle center',
					],
					'icon',
					[
						'class' => EditColumn::className(),
						'attribute' => 'url',
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
				]
			]); */ ?>
		<?php endforeach;?>
	<?php endif; ?>
	<?= Html::endForm()?>
</div>