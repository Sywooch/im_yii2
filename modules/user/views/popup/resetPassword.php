<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = Yii::t('app', 'PW_RESET');

$script = <<< JS
    jQuery('#new_password_block').modal('show');
JS;
$this->registerJs($script, yii\web\View::POS_READY); // оборачивается вjQuery(document).ready().
?>

<?php Modal::begin([
	'id' => 'new_password_block',
	'size' => 'modal-md',
	'header' => '<h2 class="text-center">'.Html::encode($this->title).'</h2><p><small>Введите новый пароль</small></p>'
]); ?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block']) ?>
		</div>
	</div>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>