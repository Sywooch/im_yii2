<?php
use yii\helpers\Html;
use app\modules\product\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
use app\components\widgets\Related;
use app\components\widgets\Breadcrumbs;
use app\modules\catalog\components\BlockCatalog;

use pistol88\cart\widgets\BuyButton;
use pistol88\cart\widgets\ChangeCount;
use pistol88\cart\widgets\ChangeOptions;

use app\modules\fav\widgets\FavButton;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $product->title;
?>
<div class="product-view ptb-10">
	<div class="container">
		<div class="row">
			<div class="product-list-wrapper">
			
				<?php if($product): ?>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div class="product-media">
							
							<!-- Tab panes -->
							<?php if($product->files):?>
								<div class="tab-content">
									<?php foreach($product->files as $key => $file): ?>
										<div role="tabpanel" class="tab-pane<?php if(!$key): ?> active<?php endif; ?>" id="image<?= $key+1 ?>">
											<div class="product-img">
												<a href="<?= Img::_(Module::getInstance()->imagesDirectory, $product->id, 'vertical-large', $file->filename) ?>" class="fancybox" rel="product-images">
													<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $product->id, 'middle-square', $file->filename) ?>" alt="">
												</a>
											</div>
										</div>
									<?php endforeach; ?>
								</div> 
							<?php endif; ?>
							
							<?php if($product->files AND count($product->files)>1): ?>
								<!-- Nav tabs -->
								<ul class="product-media-tabs" role="tablist">
									<?php foreach($product->files as $key => $file): ?>
										<li role="presentation" class="<?php if(!$key): ?>active<?php endif; ?>">
											<a href="#image<?= $key+1 ?>" aria-controls="image<?= $key+1 ?>" role="tab" data-toggle="tab">
											<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $product->id, 'middle-square', $file->filename) ?>" alt="">
											</a>
										</li>
									<?php endforeach; ?>
								</ul> 
							<?php endif; ?>
						</div>
						<!--/product-media-->
						
						<?php if($product->features): ?>
							<br>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th colspan="2">Основные характеристики товара</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($product->getFeatures()->orderBy('weight')->all() as $key => $feature):?>
										<tr>
											<td><?= $feature->name ?></td>
											<td><?= $feature->value ?></td>
										</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						<?php endif; ?>
					</div>
								
					<div class="col-md-7 col-sm-7 col-xs-12">
						<div class="product-content">
							<?= Text::_edit($product->id, 'product') ?> <!-- Ссылка на редактирование материала -->
							<div class="section-title section-title-shop">
								<?//= Breadcrumbs::widget([
									//'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
								//]) ?>
								<h1><?= Html::encode($product->title) ?></h1>
							</div>
							
							<div class="product-info-stock-sku">
								<?php //if($product['manufacturer'] AND !empty($product['manufacturer'])): ?>
									<div>
										<label>Производитель: </label>
										<span class="color"><?//= $product['manufacturer'] ?></span>
									</div>
								<?php //endif; ?>
								
								<?php //if($product['quantity']): ?>
									<span class="color">Товар в наличии</span>
								<?php //else: ?>
							
								<?php //endif; ?>

								<div>
									<label>Артикул: </label>
									<span class="color"><?= $product->id ?></span>
								</div>
							</div>
							<div class="product-desc">
								<?= $product->body ?>
							</div>
							
							<div class="price-box">
								<span class="new-price"><?= $product->price ?> р.</span>
							</div>
							
							<?= ChangeOptions::widget(['model' => $product]);?>
							
							<!--<?php //if($product['attributes']): ?>
								<?php //foreach($product['attributes'] as $attribute_group_id => $attribute_group): ?>
									<?php //if($attribute_group['attributes']): ?>
										<div class="p-size clear">
											<p class="product-condition clear">
												Выберите <?//= $attribute_group['attribute_group_lang_name'][Data::_('lang_id')] ?>:
											</p>
											<div class="size-selact">
												<select name="product_option" id="product_option_<?//= $product['code'] ?>_card">
													<option value=""> - <?//= $attribute_group['attribute_group_lang_name'][Data::_('lang_id')] ?> - </option>
													<?php //foreach($attribute_group['attributes'] as $key => $option): ?>
														<?php //if($option['attribute_sku'] != ''){$option_code = $option['attribute_sku'];} else {$option_code = $option['attribute_id'];} ?>
														
														<option value="<?//= $option_code ?>"><?//= $option['attribute_lang_name'][Data::_('lang_id')] ?></option>
															
													<?php //endforeach; ?>

												</select> 
												<label class="error" id="product_option_<?//= $product->id ?>_card_error" style="display:none;">Для заказа товара необходимо выбрать <?//= $attribute_group['attribute_group_lang_name'][Data::_('lang_id')] ?>!</label>
											</div>
										</div>
									<?php //endif; ?>
								<?php //endforeach; ?>
							<?php //else: ?>
								<input type="hidden" name="product_option" id="product_option_<?//= $product->id ?>_card" value="0">
							<?php //endif; ?>-->
									
							<div class="pro-actions pt-20">
								
								<?= ChangeCount::widget(['model' => $product]);?>
								
								<?= BuyButton::widget([
									'model' => $product,
									'text' => '<i class="fa fa-cart-plus" aria-hidden="true"></i><span> Купить</span>',
									'htmlTag' => 'a',
									'cssClass' => 'add-cart'
								]) ?>
								
								<?= FavButton::widget([
									'model' => $product,
									'text' => '<i class="fa fa-cart-plus" aria-hidden="true"></i><span> Отложить</span>',
									'htmlTag' => 'a',
									'cssClass' => 'fav-cart'
								]) ?>

								<!--<a onclick="addToCart('<?= $product->id ?>', 'card');" title="В корзину" class="add-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i><span> Купить</span></a>
								<a onclick="addToFav('<?= $product->id ?>');" title="Отложить"><i class="fa fa-star-o" aria-hidden="true"></i></a>-->
								<a href="#recall" class="fancybox"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
							</div>

						</div>
					</div>
				<?php else: ?>
					<div class="section-title section-title-shop">
						<h2><?= $text_page_not_found ?></h2>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!--/product-view-->