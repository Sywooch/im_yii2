<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\address\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= Html::hiddenInput('Address[user_id]', $model->user_id) ?>
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-xs-12 col-md-4 col-lg-4">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-4 col-lg-4">
			<?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-4 col-lg-4">
			<?= $form->field($model, 'postlastname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'postname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'postphathername')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-4 col-lg-4">
			<?= $form->field($model, 'comment')->textarea(['rows' => 4]); ?>
		</div>
		<div class="col-xs-12 col-md-4 col-lg-4">
		</div>
		<div class="col-xs-12 col-md-4 col-lg-4">
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