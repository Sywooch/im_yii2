<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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
					'id' => 'reset-password-form',
					'method' => 'post',
					'options' => ['class' => 'form'],
					'fieldConfig' => [
						'template' => '{label}{input}{error}',
						'errorOptions' => ['class' => 'error'],
					],
					'errorCssClass' => 'error',
				]); ?>

					<?= $form->field($model, 'password')->passwordInput() ?>

					<div class="form-group">
						<?= Html::submitButton('Сохранить') ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>