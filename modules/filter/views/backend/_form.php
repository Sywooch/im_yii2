<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\filter\Module;
?>

<div class="<?= Module::getInstance()->id ?>-form">

    <hr>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="row">
        <div class="col-xs-6 col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
		<div class="col-xs-6 col-md-4">
            <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-4 col-md-2">
            <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>