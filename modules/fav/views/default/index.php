<?php
use yii\helpers\Html;
use app\modules\file\components\Img;
use app\modules\fav\widgets\DeleteButton;
use app\modules\fav\widgets\TruncateButton;

?>
<div class="fav-main-area pt-10">
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
					<div class="table-content table-responsive" id="favtable">
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
									<tr class="favrow<?= $element->getModel()->getFavId() ?>">
										<td class="product-thumbnail">
											<a href="/products/<?= $element->getModel()->getFavAlias() ?>"><img src="<?= Img::_('product', $element->getModel()->getFavId(), 'middle-square', $element->getModel()->getFavThumb()) ?>"></a>
										</td>
										<td class="product-name">
											<a href="/products/<?= $element->getModel()->getFavAlias() ?>"><?= $element->getModel()->getFavName() ?></a>
										</td>	
										<td class="product-price">
											<span class="amount"><?= $element->getModel()->getFavPrice() ?> р.</span>		 										
										</td> 	
										<td class="product-quantity">
											
										</td> 	
										<td class="product-subtotal">
																			
										</td> 
										<td class="product-remove">
											<?= DeleteButton::widget(['model' => $element, 'text' => '<i class="fa fa-times"></i>', 'cssClass' => '', 'lineSelector' => 'tr.favrow'.$element->getModel()->getFavId()]) ?>
										</td> 
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					
					<div class="row">
						<div class="col-md-8 col-sm-7 col-xs-12">
							<div class="buttons-cart">
								<?= TruncateButton::widget(['lineSelector' => '#favtable']) ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!--/fav-main-area-->
