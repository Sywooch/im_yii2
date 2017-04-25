<?php
use yii\helpers\Html;
use app\modules\product\Module;
use app\modules\file\components\Img;
use app\modules\infoblock\components\BlockText;
?>
<?php if ($product): ?>
	<?php foreach($product as $item): ?>
	
		<div class="col-md-4">
			<div class="product-wrapper first">
				<input type="hidden" value="1" id="product_qty_<?= $item->id ?>_products">
				<div class="product-img">
			
					<a href="/products/<?= $item->alias ?>">
						<?php if($item->thumb):?>
							<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $item->id, 'big-square', $item->thumb->filename) ?>" alt="">
						<?php endif; ?>
					</a>
					<div class="pro-actions">
						<a onclick="addToCart('<?= $item->id ?>', 'products');" title="Добавить в корзину"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
						<a onclick="addToFav('<?= $item->id ?>');" title="Отложить"><i class="fa fa-star-o" aria-hidden="true"></i></a>
						<a href="<?= Img::_(Module::getInstance()->imagesDirectory, $item->id, 'big-square', $item->thumb->filename) ?>" class="fancybox" title="<?= $item->title ?>"><i class="fa fa-arrows" aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="product-content">
					<h2><a href="/products/<?= $item->alias ?>"><?= $item->title ?></a></h2>
					
					<div class="price-box">
						<span class="new-price"><?= $item->price ?> р.</span>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>