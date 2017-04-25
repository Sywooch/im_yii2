<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = Yii::t('app', 'TITLE_LOGIN');
$script = <<< JS
    jQuery('#login_block').modal('show');
	jQuery('#login-form input[name=\'username\'], #login-form input[name=\'password\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			jQuery('#login-form').submit();
		}
	});
JS;
$this->registerJs($script, yii\web\View::POS_READY); // оборачивается вjQuery(document).ready(). This is the default value. Note that by using this position, the method will automatically register the jQuery js file.
?>
<?php Modal::begin([
	'id' => 'login_block',
	'size' => 'modal-sm',
	'header' => '<h2 class="text-center">'.Html::encode($this->title).'</h2><p><small>Введите ваш логин и пароль для авторизации</small></p>'
]); ?>
 
<?php $form = ActiveForm::begin([
	'id' => 'login-form',
]); ?>

	<?= $form->field($model, 'username') ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'rememberMe')->checkbox([
		/* 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>", */
	]) ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
		</div>
	</div>
	
	<p>Забыли пароль? <?= Html::a('Вспомнить', ['password-reset-request']) ?></p>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>