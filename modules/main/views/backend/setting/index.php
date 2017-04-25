<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\components\widgets\backend\grid\EditColumn;
use app\modules\main\Module;

$this->title = 'Параметры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <h3><?= Html::encode($this->title) ?></h3>
	<hr>
	<?php $form = ActiveForm::begin(['action' => '/admin/' . Module::getInstance()->id . '/setting/create-fast']); ?>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-3">
			<?= $form->field($newModel, 'name')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<?= $form->field($newModel, 'value')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="form-group pd-top-25">
				<?= Html::submitButton('Быстро создать новый параметр', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	<hr>
    <p>
        <?= Html::a('Создать новый параметр', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
    </p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/setting/multi-action', 'post', ['id' => 'update_form']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
			[
				'class' => EditColumn::className(),
				'attribute' => 'value',
				'style' => 'middle center',
			],
            'module',
            [	
				'class' => 'yii\grid\ActionColumn', 
				'template' => '<p class="text-right">{update}&nbsp;&nbsp;{delete}</p>'
			],
        ],
    ]); ?>
	<?= Html::endForm()?>
</div>
