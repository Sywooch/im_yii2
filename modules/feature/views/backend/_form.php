<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\feature\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= Html::hiddenInput('Feature[content_id]', $model->content_id) ?>
	<?= Html::hiddenInput('Feature[module]', $model->module) ?>
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'in_filter')->checkbox() ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
</div>