<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin([
	'id' => 'contact_form',
	'method' => 'post',
	'options' => ['class' => 'form'],
	'fieldConfig' => [
		'template' => '{label}{input}{error}',
		'errorOptions' => ['class' => 'error'],
	],
	'errorCssClass' => 'error',
]); ?>

	<?= $form->field($model, 'name')->textInput()->label('Ваше имя') ?>
	<?= $form->field($model, 'contact')->textInput()->label('Ваш телефон или E-mail') ?>
	<?= $form->field($model, 'text')->textarea(['rows' => 3])->label('Ваше сообщение') ?>

	<div class="form-group">
		<button type="submit">отправить</button>
	</div>
	<div class="form_success" style="display:none;"></div>
<?php ActiveForm::end(); ?>