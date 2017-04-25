<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin([
	'id' => 'search_form'.$class,
	'action' => '/products',
	'method' => 'get',
	'options' => ['class' => ''.$class],
	'fieldConfig' => [
		'template' => '{input}',
		'errorOptions' => ['class' => 'error'],
	],
	'errorCssClass' => 'error',
]); ?>

<div class="control">
	<?= $form->field($model, 'q')->textInput(['value' => $q, 'placeholder' => 'Что вы ищите? ...']); ?>
	<button class="search-icon search-icon3" type="submit" title="Найти"></button>
</div>
<?php ActiveForm::end(); ?>