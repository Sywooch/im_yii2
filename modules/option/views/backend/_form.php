<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\option\models\Option;
use app\modules\file\components\Img;

use app\modules\option\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

	<hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= Html::hiddenInput('Option[content_id]', $model->content_id) ?>
	<?= Html::hiddenInput('Option[module]', $model->module) ?>
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-xs-12 col-md-8">
			<?= $form->field($model, 'option_type')->dropDownList(Option::getOptionTypesArray()) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-4">
			<label>Картинка(иконка)</label>
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

    <?php ActiveForm::end(); ?>
</div>