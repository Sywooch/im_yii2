<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
//use vova07\imperavi\Widget;

use mihaildev\ckeditor\CKEditor;

use app\modules\file\components\Img;
use app\modules\seo\components\Seo;
//use app\components\redactorSetting;
use app\components\widgets\SelectTreeItems;
use app\modules\catalog\Module;
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
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'status')->checkbox() ?>
		</div>
		<div class="col-xs-12 col-md-8">
			<?= $form->field($model, 'in_front')->checkbox() ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-md-8">
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<?= $form->field($model, 'weight')->textInput(['maxlength' => true, 'class' => 'form-control col-md-4']) ?>
				</div>
				<div class="col-xs-12 col-md-8">
					<div class="form-group field-catalog-catalogArray required">
						<label class="control-label" for="catalog-catalogArray">Родительский материал</label>
						<select class="form-control" name="Catalog[catalogArray][]" multiple size="10">
							<option value="">.. нет ..</option>
							<?= SelectTreeItems::widget([
								'data' => $selectItems,
								'model' => $model,
								'childRelation' => 'children',
								'parentField' => 'parent_id',
								'isMany' => true, // true - если виджет используется в модуле catalog, false - если в модуле menu (обусловленно особенностью данной разработки)
							]); ?>
						</select>
						<div class="help-block"></div>
					</div>
					
					<?//= $form->field($model, 'catalogArray')->dropDownList(ArrayHelper::map($selectItems, 'id', 'title'), ['size' => 10, 'multiple' => true, 'prompt' => '.. нет ..']) ?>
					<?//= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($parentItems, 'id', 'title'), ['prompt' => '.. нет ..', 'options' => [$model->parent_id => ['class' => 'selected']]]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<?= $form->field($model, 'short_title')->textInput(['maxlength' => true, 'required' => true]) ?>
				</div>
				<div class="col-xs-12 col-md-8">
					<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
			<?= $form->field($model, 'text1')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('Алиас (!если поле не заполнено, генерируется автоматически из наименования методом транслитерации)') ?>
		</div>
		<div class="col-xs-12 col-md-4">
			<label>Главная картинка(иконка)</label>
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
    
	<hr>
	
	<?php echo Collapse::widget([
		'items' => [
			[
				'label' => 'Фотогалерея',
				'content' => Img::_galleryView(Module::getInstance()->imagesDirectory, $model, $form, 'thumbgall', 'files', 'imageGallery[]', 'Фотогалерея')
			]
		]
	]); ?>
	
	<div class="row">
		<div class="col-xs-12 col-md-12">
			<?= $form->field($model, 'teaser')->textarea(['rows' => 6])->widget(CKEditor::className(),[
				'editorOptions' => [
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
				],
			]); ?>
		</div>
	</div>
	
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
						'label' => 'SEO',
						'content' => Seo::_fieldsView($model)
					]
				]
			]); ?>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>