<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\components\helpers\Text;
use yii\bootstrap\ActiveForm;
use app\modules\file\components\Img;
use app\modules\infoblock\components\BlockText;
use app\modules\product\models\Product;
use app\modules\training\models\Training;

use app\components\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = $this->title;
$this->params['page-action'] = 'page-article';
?>
<div class="product-view ptb-10">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title section-title-shop">
					<?= Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
					<h1>Личный кабинет</h1>
				</div>

				<?php if($profileModel):?>

					<div class="cont cont-cards">
						<div class="cont-cards__item">
							<?php $form1 = ActiveForm::begin([
								'id' => 'form-edit-profile',
								'method' => 'post',
								'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
								'fieldConfig' => [
									'template' => '{label}{input}{error}',
									'errorOptions' => ['class' => 'error'],
								],
								'errorCssClass' => 'error',
							]); ?>

								<?= $form1->field($profileModel, 'name')->textInput() ?>
								<?= $form1->field($userModel, 'email')->textInput() ?>
								<?= $form1->field($profileModel, 'phone')->textInput() ?>
								<div class="form-group">
									<?= Html::submitButton('Изменить информацию') ?>
								</div>
							<?php ActiveForm::end(); ?>
						</div>

						<div class="cont-cards__item">
							<?php $form2 = ActiveForm::begin([
								'id' => 'form-password-profile',
								'method' => 'post',
								'options' => ['class' => 'form', 'enctype' => 'multipart/form-data'],
								'fieldConfig' => [
									'template' => '{label}{input}{error}',
									'errorOptions' => ['class' => 'error'],
								],
								'errorCssClass' => 'error',
							]); ?>
			 
								<?= $form2->field($passwordModel, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
								<?= $form2->field($passwordModel, 'newPassword')->passwordInput(['maxlength' => true]) ?>
								<?= $form2->field($passwordModel, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>
					 
								<!--<div class="form-group form-group_check">
									<input type="checkbox" id="check-1">
									<label for="check-1">Сгенерировать пароль</label>
								</div>-->
								
								<div class="form-group">
									<?= Html::submitButton('Изменить пароль') ?>
								</div>
					 
							<?php ActiveForm::end(); ?>
						</div>
					</div>
					<h2 class="h-main">История заказов</h1>

				<?php else:?>
					<h2>У вас нет профиля, если это ошибка, обратитесь к администратору.</h2>
				<?php endif;?>
				
				<?php if($userModel->orders):?>
					<table class="cabinet-table">
						<?php foreach($userModel->orders as $order):?>
							<?php if($order->orderProducts):?>
								<?php foreach($order->orderProducts as $item):?>
									<?php if($order->type == 'product'):?>
										<?php $productInfo = Product::findOne($item->product_id); ?>
										<tr>
											<?php if($productInfo):?>
												<td><?= $order->getTypeName($order->type) ?> <a href="/products/<?= $productInfo->alias ?>"><?= $item->product_title ?></a></td>
											<?php else:?>
												<td><?= $order->getTypeName($order->type) ?> <a href="#"><?= $item->product_title ?> (нет)</a></td>
											<?php endif;?>
											<td><?= Text::_date($order->date, '.', ' ', ' г.')?></td>
											<td><b><?= $item->product_total ?> руб.</b></td>
										</tr>
									<?php elseif($order->type == 'training'):?>
										<?php $productInfo = Training::findOne($item->product_id); ?>
										<tr>
											<?php if($productInfo):?>
												<td><?= $order->getTypeName($order->type) ?> <a href="/training/<?= $productInfo->alias ?>"><?= $item->product_title ?></a></td>
											<?php else:?>
												<td><?= $order->getTypeName($order->type) ?> <a href="#"><?= $item->product_title ?> (нет)</a></td>
											<?php endif;?>
											<td><?= Text::_date($order->date, '.', ' ', ' г.')?></td>
											<td><b><?= $item->product_total ?> руб.</b></td>
										</tr>
									<?php endif;?>
								<?php endforeach;?>
							<?php endif;?>
						<?php endforeach;?>
					</table>
				<?php else:?>
					<h3>У вас пока нет заказов.</h3>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>