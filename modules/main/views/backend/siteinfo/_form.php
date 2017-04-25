<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
//use vova07\imperavi\Widget;

use mihaildev\ckeditor\CKEditor;

use app\modules\main\Module;
use app\modules\seo\components\Seo;
//use app\components\redactorSetting;
use app\modules\file\components\Img;
/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="siteinfo-form">
	<hr>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-8 col-md-10">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-md-6">
			<?= $form->field($model, 'slogan')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'copyright')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
			<?//= $form->field($model, 'phone')->textarea(['rows' => 3])->widget(CKEditor::className(),[
			//	'editorOptions' => [
			//		'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
			//		'inline' => false, //по умолчанию false
			//	],
			//]); ?>
			<?= $form->field($model, 'address')->textarea(['rows' => 6])->widget(CKEditor::className(),[
				'editorOptions' => [
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
				],
			]); ?>
		</div>
		<div class="col-xs-12 col-md-6">
			<hr>
			<?php if($model->logo):?>
				<div class="row">
					<div class="col-xs-12 col-md-12" id="<?= Module::getInstance()->imagesDirectory ?>_<?= $model->id ?>_<?= $model->logo->id ?>_imageblock">
						<a onclick="deleteImage('<?= Module::getInstance()->imagesDirectory ?>', '<?= $model->id ?>', '<?= $model->logo->filename ?>', '<?= $model->logo->id ?>');" class="thumbnail" data-toggle="tooltip" data-placement="top" title="Удалить это изображение">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->logo->filename) ?>">
						</a>
					</div>
				</div>
			<?php endif; ?>
			<?= $form->field($model, 'logoFile')->fileInput(['accept' => 'image/*']) ?>
			<hr>
			<?php if($model->icon):?>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<img src="/<?= $model->icon->filename ?>">
					</div>
				</div>
			<?php endif; ?>
			<?= $form->field($model, 'iconFile')->fileInput(['accept' => 'image/*']) ?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12 col-md-12">
			<?= $form->field($model, 'body')->textarea(['rows' => 6])->widget(CKEditor::className(),[
				'editorOptions' => [
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
				],
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
			<?php echo Collapse::widget([
				'items' => [
					[
						'label' => 'Коды для вставки',
						'content' => $form->field($model, 'map')->textarea(['rows' => 6])
							.$form->field($model, 'counter')->textarea(['rows' => 6])
					],
					[
						'label' => 'SEO',
						'content' => Seo::_fieldsView($model)
					]
				]
			]); ?>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>