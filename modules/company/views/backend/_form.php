<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\company\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= Html::hiddenInput('Company[user_id]', $model->user_id) ?>
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
			<?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
			<?= $form->field($model, 'bankname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'bik')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'kpp')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'rs')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'ks')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-6 col-lg-6">
			<?= $form->field($model, 'comment')->textarea(['rows' => 4]); ?>
		</div>
		<div class="col-xs-12 col-md-6 col-lg-6">
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>
</div>