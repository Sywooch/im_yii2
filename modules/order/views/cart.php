<?php
use yii\helpers\Html;
use app\modules\file\components\Img;
use yii\helpers\ArrayHelper;

use pistol88\cart\widgets\DeleteButton;
use pistol88\cart\widgets\TruncateButton;
use pistol88\cart\widgets\ChangeCount;
use pistol88\cart\widgets\CartInformer;
use pistol88\cart\widgets\ChangeOptions;

use app\modules\option\models\Option;

use yii\bootstrap\ActiveForm;

?>
<div class="cart-main-area pt-10">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			
				<?php if(!Yii::$app->user->isGuest): ?>
				
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/account" class="button">Личные данные</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/cart" class="button">Ваша корзина</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/favorites" class="button">Избранные товары</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/account/orders" class="button">История заказов</a>
							</div>
						</div>
					</div>
				
				<?php else: ?>
					
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/cart" class="button">Ваша корзина</a>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="buttons-cart">
								<a href="/favorites" class="button">Избранные товары</a>
							</div>
						</div>
					</div>
					
				<?php endif; ?>
			
				<div class="section-title section-title-shop">
					<h1><?= Html::encode($this->title) ?></h1>
				</div>
			
				<?php $count = count($elements); if($count > 0): ?>

					<div class="table-content table-responsive" id="carttable">
						<table>
							<thead>
								<tr>
									<th class="product-thumbnail">Фото</th>
									<th class="product-name">Название товара</th>
									<th class="product-price">Цена</th>
									<th class="product-quantity">Кол-во</th>
									<th class="product-subtotal">Сумма</th>
									<th class="product-remove"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($elements as $element): ?>
									<tr class="cartrow<?= $element->getModel()->getCartId() ?>">
										<td class="product-thumbnail">
											<a href="/products/<?= $element->getModel()->getCartAlias() ?>"><img src="<?= Img::_('product', $element->getModel()->getCartId(), 'middle-square', $element->getModel()->getCartThumb()) ?>"></a>
										</td>
										<td class="product-name">
											<a href="/products/<?= $element->getModel()->getCartAlias() ?>"><?= $element->getModel()->getCartName() ?></a>
											<?php $optionsArray = json_decode($element->options, true); ?>
											<?php if($optionsArray && !empty($optionsArray)): ?>
												<?php foreach($optionsArray as $optionType => $optionCode): ?>
													<br>
													<?= Option::getOptionTypeName($optionType) ?> : <?= Option::getOptionName($optionType, $element->getModel()->getCartId(), $optionCode) ?>
												<?php endforeach; ?>
											<?php endif; ?>
										</td>	
										<td class="product-price">
											<span class="amount"><?= $element->getModel()->getCartPrice() ?> р.</span>		 										
										</td> 	
										<td class="product-quantity">
											<?= ChangeCount::widget(['model' => $element]) ?>
										</td> 	
										<td class="product-subtotal">
																			
										</td> 
										<td class="product-remove">
											<?= DeleteButton::widget(['model' => $element, 'text' => '<i class="fa fa-times"></i>', 'cssClass' => '', 'lineSelector' => 'tr.cartrow'.$element->getModel()->getCartId()]) ?>
										</td> 
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-8 col-sm-7 col-xs-12">
							<div class="buttons-cart">
								<?= TruncateButton::widget(['lineSelector' => '#carttable']) ?>
							</div>
						</div>
						<div class="col-md-4 col-sm-5 col-xs-12">
							<div class="cart_totals">
								<h2>итого</h2>
								<table>
									<tbody>
										<tr class="order-total">
											<th></th>
											<td>
												<?= CartInformer::widget(['htmlTag' => 'h3', 'text' => '{p}']) ?>
											</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
					
					<div class="main-form">
					
						<div class="section-title section-title-shop">
							<h2>Оформление заказа</h2>
						</div>
						
						<?php $form = ActiveForm::begin([
							'id' => 'order_form',
							'action' => '/order/default/index',
							'method' => 'post',
							'options' => ['class' => 'form'],
							'fieldConfig' => [
								'template' => '{label}{input}{error}',
								'errorOptions' => ['class' => 'error'],
							],
							'errorCssClass' => 'error',
						]); ?>

						<?= $form->field($model, 'name')->textInput(['placeholder' => 'Ваше имя'])->label('Имя') ?>
						<?= $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label('Номер телефона') ?>
						<?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail адрес'])->label('E-mail адрес') ?>
						
						<?= $form->field($model, 'shipping')->radioList(ArrayHelper::map($shippingMethods, 'id', 'title'), []) ?>
						<?= $form->field($model, 'payment')->radioList(ArrayHelper::map($paymentMethods, 'id', 'title'), []) ?>
						
						<?= $form->field($model, 'text')->textarea(['placeholder' => 'Комментарий к заказу'])->label('Комментарий к заказу') ?>

						<div class="form-group group-submit">
							<button type="submit">Оформить заказ</button>
						</div>
						<?php ActiveForm::end(); ?>
						
						
						<!--<form id="order_form" action="/checkout" method="post" class="form checkout-form">
						
							<p class="fill-text">Пожалуйста заполните ваши контактные данные для совершения заказа.</p>
							<p class="requer">*Поля обязалельные для заполнения</p>
							
							<input type="hidden" name="total" value="<?//= $products['total'] ?>">
							<input type="hidden" name="delivery" value="<?//= $products['delivery'] ?>">
							<input type="hidden" name="sale" value="<?//= $products['all_sale'] ?>">
							<input type="hidden" name="bonus" value="<?//= $products['all_bonus'] ?>">
							<input type="hidden" name="promocode" value="<?//= $products['promocode'] ?>">
						
							<div class="form-group">
								<label for="name">ФИО *</label>
								<input type="text" name="name" placeholder="Ваше имя" value="<?php if($userinfo):?><?= $userinfo['name'] ?><?php endif; ?>">
							</div>
							
							<div class="form-group">
								<label for="email">E-mail *</label>
								<input type="text" name="email" placeholder="Ваш e-mail адрес" value="<?php if($userinfo):?><?= Data::_('user')->email ?><?php endif; ?>">
							</div>
							
							<div class="form-group">
								<label for="phone">Телефон *</label>
								<input type="text" name="phone" placeholder="Телефон для связи с вами" value="<?php if($userinfo):?><?= $userinfo['phone'] ?><?php endif; ?>">
							</div>
							
							<?php if(isset($order['payment']) AND count($order['payment'])>0): ?>
								<div class="form-group">
									<label for="payment">Выберите способ оплаты</label>
									<?php foreach($order['payment'] as $pay_id => $value): ?>
										<div class="checkbox">
											<label for="payment<?= $pay_id ?>" id="payment_label<?= $pay_id ?>"><input type="radio" name="payment" id="payment<?= $pay_id ?>" value="<?= $pay_id ?>" <?php if($pay_id == 1): ?>checked<?php endif; ?>><img src="<?//= $value['image'] ?>" class="payment_icon"> <?= $value['name'] ?></label>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							
							<?php if(isset($order['shipping']) AND count($order['shipping'])>0): ?>
								<hr>
								<div class="form-group">
									<label for="shipping">Выберите способ получения товара</label>
									<?php foreach($order['shipping'] as $shipp_id => $value): ?>
										<div class="checkbox">
											<label for="shipping<?= $shipp_id ?>"><input type="radio" name="shipping" <?= $value['onclick'] ?> id="shipping<?= $shipp_id ?>" value="<?= $shipp_id ?>" <?php if($shipp_id == 1): ?>checked<?php endif; ?>> <?= $value['name'] ?></label>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							
							<div id="addresses_block" style="display:none;background:#d4d4d4;padding:25px;margin-bottom:25px;">
								<div class="form-group">
									<label for="postcode">Почтовый индекс</label>
									<input type="text" name="postcode" class="not-validation" placeholder="Почтовый индекс">
								</div>
								
								<div class="form-group">
									<label for="city">Город *</label>
									<input type="text" name="city" class="not-validation" placeholder="Ваш город" value="Новосибирск">
								</div>
								
								<div class="form-group">
									<label for="address">Адрес *</label>
									<input type="text" name="address" class="not-validation" placeholder="Куда доставить товар?">
								</div>
							</div>
							
							<div class="form-group">
								<label for="comment">Дополнительная информация</label><br>
								<textarea name="comment" placeholder="Дополнительная информация"></textarea>
							</div>
							
							<div class="form-group">
								<label for="agree">
									<input type="checkbox" name="agree" value="1">
									Я согласен(а) с <a href="/oferta" target="_blank">условиями</a> работы интернет магазина.
								</label>
							</div>
							
							
							<div class="wc-proceed-to-checkout">
								<button class="button" type="submit">Оформить заказ</button>
							</div>
						</form>-->
					</div>
				
				<?php else: ?>
					
				<?php endif; ?>	
				
			</div>
		</div>
	</div>
</div>
<!--/cart-main-area-->