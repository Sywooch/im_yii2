<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use app\components\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = $this->title;
$this->params['page_class'] = 'page-action';
?>
<div class="product-view ptb-10">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title section-title-shop">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
					<h1><?= $this->title ?></h1>	
				</div>

				<?php $form = ActiveForm::begin([
					'id' => 'login-form',
					'method' => 'post',
					'options' => ['class' => 'form'],
					'fieldConfig' => [
						'template' => '{label}{input}{error}',
						'errorOptions' => ['class' => 'error'],
					],
					'errorCssClass' => 'error',
				]); ?>
				
				<?= $form->field($model, 'username') ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'rememberMe')->checkbox([
					/* 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>", */
				]) ?>

				<div class="form-group">
					<?= Html::submitButton('Войти') ?>
				</div>
				
				<div class="form-links">
					<?= Html::a('Регистрация', ['/account/signup']) ?>
					<?= Html::a('Восстановление пароля', ['/account/password-reset-request']) ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>