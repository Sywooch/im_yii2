<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

use app\modules\file\components\Img;
use app\components\redactorSetting;

use app\modules\banner\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<div class="row">
		<div class="col-xs-6 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-6 col-md-10">
			<?= $form->field($model, 'status')->checkbox() ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-8">
			<?= $form->field($model, 'text_block1')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'text_block2')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-4">
			<label>Изображение баннера</label>
			<?php if($model->thumb):?>
				<div class="row">
					<div class="col-xs-12 col-md-12" id="<?= Module::getInstance()->imagesDirectory ?>_<?= $model->id ?>_<?= $model->thumb->id ?>_imageblock">
						<a onclick="deleteImage('<?= Module::getInstance()->imagesDirectory ?>', '<?= $model->id ?>', '<?= $model->thumb->filename ?>', '<?= $model->thumb->id ?>');" class="thumbnail" data-toggle="tooltip" data-placement="top" title="Удалить это изображение">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename) ?>">
						</a>
					</div>
				</div>
			<?php endif; ?>
			<?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-12">
			<?= $form->field($model, 'text_block3')->textarea(['rows' => 6])->widget(Widget::className(), [
				'settings' => redactorSetting::_($model->id, Module::getInstance()->imagesDirectory)
			]); ?>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-8 col-md-10">

		</div>
	</div>

    <?php ActiveForm::end(); ?>
</div>