<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="popup mfp-hide" id="prod">
	<h3 class="popup_header popup_header_small">Заказ товара</h3>
	<h3 class="popup_header popup_header_vsmall"><span class="popup_header_info"></span></h3>
	<?php $form = ActiveForm::begin([
		'id' => 'product_form',
		//'action' => '/main/default/send-product-form',
		'method' => 'post',
		'options' => ['class' => 'form'],
		'fieldConfig' => [
			'template' => '{label}{input}{error}',
			'errorOptions' => ['class' => 'error'],
		],
		'errorCssClass' => 'error',
	]); ?>

	<?= Html::hiddenInput('FormProduct[product_id]', '', ['class' => 'product_id']) ?>

	<?= $form->field($model, 'name')->textInput(['placeholder' => 'Ваше имя'])->label('Имя') ?>
	<?= $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label('Номер телефона') ?>
	<?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail адрес'])->label('E-mail адрес') ?>
	<?= $form->field($model, 'text')->textarea(['placeholder' => 'Комментарий к заказу'])->label('Комментарий к заказу') ?>

	<div class="form-group group-submit">
		<button type="submit">Купить <img src="/img/loader.gif" class="loading" style="display:none;"></button>
	</div>
	<div class="form_success" style="display:none;"></div>
	<?php ActiveForm::end(); ?>
</div>
