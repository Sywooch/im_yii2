<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\file\components\Img;
use app\modules\banner\Module;
use yii\grid\GridView;
use app\components\widgets\backend\grid\StatusColumn;
use app\components\widgets\backend\grid\EditColumn;
$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-index">
    <h3><?= Html::encode($this->title) ?></h3>
	<hr>
	<?php $form = ActiveForm::begin(['action' => '/admin/' . Module::getInstance()->id . '/create']); ?>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-3">
			<?= $form->field($newModel, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="form-group pd-top-25">
				<?= Html::submitButton('Быстро создать новый баннер', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	<hr>
	<p>
		<?= Html::a('Создать новый баннер', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
	</p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\CheckboxColumn'],
			[
				'attribute' => 'imageFile',
				'format' => 'html',
				'value' => function ($model, $key, $index, $column) {
					return '<img src="'.Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename).'">';
				}
			],
			[
				'class' => EditColumn::className(), //Img::_(Module::getInstance()->imagesDirectory, $item->id, 'thumbnail', $item->thumb->filename)
				'attribute' => 'text_block1',
			],
			'text_block3:html',
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
			],
		],
	]); ?>
	<?= Html::endForm()?>
</div>