<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;

$this->title = Yii::t('app', 'TITLE_SIGNUP');
$script = <<< JS
    jQuery('#reg_block').modal('show');
JS;
$this->registerJs($script, yii\web\View::POS_READY); // оборачивается вjQuery(document).ready().
?>

<?php Modal::begin([
	'id' => 'reg_block',
	'size' => 'modal-md',
	'header' => '<h2 class="text-center">'.Html::encode($this->title).'</h2><p><small>Заполните все необходимые поля и нажмите "Отправить".</small></p>'
]); ?>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	'captchaAction' => '/user/default/captcha',
	'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>

<div class="form-group">
	<div class="">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>
	</div>
</div>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>