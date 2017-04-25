<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div id="recall" class="fancy-hidden">
	<?php $form = ActiveForm::begin([
		'id' => 'recall_form',
		'method' => 'post',
		'options' => ['class' => 'form'],
		'fieldConfig' => [
			'template' => '{input}{error}',
			'errorOptions' => ['class' => 'error'],
		],
		'errorCssClass' => 'error',
	]); ?>
	
	<div class="section-title section-title-shop">
		<h3>Заказ звонка</h3>
	</div>
	
	<?= $form->field($model, 'name')->textInput(['placeholder' => 'Ваше имя'])->label('Имя') ?>
	<?= $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label('Номер телефона') ?>
	
	<button type="submit" class="button">Заказать <img src="/img/loader.gif" class="loading" style="display:none;"></button>
	<div class="form_success" style="display:none;"></div>
	<?php ActiveForm::end(); ?>
</div>