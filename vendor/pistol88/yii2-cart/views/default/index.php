<?php
use yii\helpers\Html;

use pistol88\cart\widgets\DeleteButton;
use pistol88\cart\widgets\TruncateButton;
use pistol88\cart\widgets\ChangeCount;
use pistol88\cart\widgets\CartInformer;
use pistol88\cart\widgets\ChangeOptions;

$this->title = 'Ваши товары';
?>
<div class="cart-main-area pt-10">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
			
				<div class="section-title section-title-shop">
					<h1><?= Html::encode($this->title) ?></h1>
				</div>

				<div class="table-content table-responsive">
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
										<?= ChangeOptions::widget(['model' => $element]) ?>
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
			</div>
		</div>
	</div>
</div>
<!--/cart-main-area-->
