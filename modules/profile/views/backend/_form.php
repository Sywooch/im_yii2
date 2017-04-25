<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;

use app\modules\file\components\Img;

use app\modules\profile\Module;
use app\modules\profile\models\Profile;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= Html::hiddenInput('Profile[user_id]', $model->user_id) ?>
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
	
	<hr>
	
	<?php //echo Collapse::widget([
		//'items' => [
		//	[
		//		'label' => 'Фото',
		//		'content' => Img::_galleryView(Module::getInstance()->imagesDirectory, $model, $form, 'thumbgall', 'files', 'imageGallery[]', 'Фото')
		//	]
		//]
	//]); ?>
	
	<div class="row">
		<div class="col-xs-12 col-md-4 col-lg-4">
			<?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'phathername')->textInput(['maxlength' => true]) ?>
			
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'sale')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'sub')->checkbox() ?>
			<?//= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>
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