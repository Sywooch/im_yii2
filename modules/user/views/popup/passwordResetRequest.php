<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = Yii::t('app', 'TITLE_PW_RECOVERY');
$script = <<< JS
    jQuery('#recovery_block').modal('show');
JS;
$this->registerJs($script, yii\web\View::POS_READY); // оборачивается вjQuery(document).ready().
?>

<?php Modal::begin([
	'id' => 'recovery_block',
	'size' => 'modal-md',
	'header' => '<h2 class="text-center">'.Html::encode($this->title).'</h2><p><small>Введите ваш email</small></p>'
]); ?>
	
<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

	<?= $form->field($model, 'email') ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-block']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>