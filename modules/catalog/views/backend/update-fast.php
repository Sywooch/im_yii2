<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use vova07\imperavi\Widget;

use app\modules\file\components\Img;
use app\components\redactorSetting;
use app\components\widgets\backend\Items;

use app\modules\catalog\Module;
?>

<?php $form = ActiveForm::begin(['id' => 'fast_update_'.Module::getInstance()->id.'_form_'.$model->id, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= Html::hiddenInput('popup_edit_redirect', '/', ['id' => 'popup_edit_redirect']) ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h3>Редактирование блока</h3>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group margin-t-15">
                <?= $form->field($model, 'status')->checkbox() ?>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group text-right margin-t-15">
                <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <?= $form->field($model, 'weight')->textInput(['maxlength' => true, 'class' => 'form-control col-md-4']) ?>
                </div>
                <div class="col-xs-12 col-md-8">
					<div class="form-group field-catalog-catalogsArray required">
						<label class="control-label" for="catalog-catalogsArray">Родительский материал</label>
						<select class="form-control" name="Catalog[catalogsArray][]" multiple size="10">
							<option value="">.. нет ..</option>
							<?= Items::selectItems($selectItems, $model) ?>
						</select>
						<div class="help-block"></div>
					</div>
					
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

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <?= $form->field($model, 'teaser')->textarea(['rows' => 6])->widget(Widget::className(), [
                'settings' => redactorSetting::_($model->id, Module::getInstance()->imagesDirectory)
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <?= $form->field($model, 'body')->textarea(['rows' => 6])->widget(Widget::className(), [
                'settings' => redactorSetting::_($model->id, Module::getInstance()->imagesDirectory)
            ]); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>