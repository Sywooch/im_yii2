<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use vova07\imperavi\Widget;

use app\modules\main\Module;
use app\components\redactorSetting;
use app\modules\file\components\Img;

?>
<?php $form = ActiveForm::begin(['id' => 'fast_update_'.Module::getInstance()->id.'_form_'.$model->id, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= Html::hiddenInput('popup_edit_redirect', '/', ['id' => 'popup_edit_redirect']) ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <h3>Редактирование блока</h3>
    </div>
    <div class="col-xs-6 col-md-3">

    </div>
    <div class="col-xs-6 col-md-3">
        <div class="form-group text-right margin-t-15">
            <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<hr>

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
        <?//= $form->field($model, 'phone')->textarea(['rows' => 3])->widget(Widget::className(), [
        //	'settings' => redactorSetting::_($model->id, Module::getInstance()->id)
        //]); ?>
        <?= $form->field($model, 'address')->textarea(['rows' => 6])->widget(Widget::className(), [
            'settings' => redactorSetting::_($model->id, Module::getInstance()->id)
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
        <?= $form->field($model, 'body')->textarea(['rows' => 6])->widget(Widget::className(), [
            'settings' => redactorSetting::_($model->id, Module::getInstance()->imagesDirectory)
        ]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
