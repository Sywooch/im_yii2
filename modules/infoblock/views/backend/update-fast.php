<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use app\components\redactorSetting;

use app\modules\infoblock\Module;

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
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('Алиас (!если поле не заполнено, генерируется автоматически из наименования методом транслитерации)') ?>
        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-12 col-md-4">

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
