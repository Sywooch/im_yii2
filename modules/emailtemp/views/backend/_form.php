<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use app\modules\emailtemp\models\Emailtemp;
//use vova07\imperavi\Widget;
//use app\components\redactorSetting;

use mihaildev\ckeditor\CKEditor;

use app\modules\emailtemp\Module;
?>

<div class="emailtemp-form">
	<hr>
	
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	
	<div class="row">
		<div class="col-xs-6 col-md-6">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-6 col-md-6">
			<?= $form->field($model, 'act')->dropDownList(Emailtemp::getActArray()) ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-6 col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-6 col-md-6">
			<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
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
			<p><b>ИНФОРМАЦИЯ: В теле и теме письма можно использовать переменные, которые будут заменены на соответствующие значения при формировании письма.<br>
			В зависимости от контекста, в разных письмах одни и те-же переменные могут содержать разные значения!</b><br>
			<?php foreach(Emailtemp::getVarsArray() as $var => $desc):?>
				[<?= $var ?>] - <small><?= $desc ?></small><br>
			<?php endforeach;?>
			</p>
		</div>
	</div>
	
    <hr>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>