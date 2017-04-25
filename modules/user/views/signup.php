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
					'id' => 'form-signup',
					'method' => 'post',
					'options' => ['class' => 'form'],
					'fieldConfig' => [
						'template' => '{label}{input}{error}',
						'errorOptions' => ['class' => 'error'],
					],
					'errorCssClass' => 'error',
				]); ?>
				
				<?= $form->field($profileModel, 'name')->textInput() ?>
				<?= $form->field($model, 'email')->textInput() ?>
				<?= $form->field($profileModel, 'phone')->textInput() ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'captchaAction' => '/user/default/captcha',
					'template' => '<div class="row"><div class="col-lg-3">{image} <small>Для обновления нажмите на рисунок</small></div><div class="col-lg-6">{input}</div></div>',
				]) ?>

				<div class="form-group">
					<?= Html::submitButton('Зарегистрироваться') ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>