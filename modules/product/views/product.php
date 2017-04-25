<?php
use yii\helpers\Html;
use app\modules\product\Module;
use app\modules\file\components\Img;
use app\modules\infoblock\components\BlockText;
use app\components\widgets\Breadcrumbs;
use app\modules\catalog\components\BlockCatalog;

use pistol88\cart\widgets\BuyButton;

$this->params['breadcrumbs'][] = $this->params['title_h1'];
?>
<div class="shop-area ptb-10">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<!-- home-two-menu -->
				<?= BlockCatalog::left() ?>
				<div id="recently_block" class="ptb-30"></div>
			</div>
			<!-- Right section Strat -->
			<div class="col-lg-9 col-md-9">
				<div class="shop-right">
					<div class="section-title section-title-shop">
						<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						]) ?>
						<h1><?= Html::encode($this->params['title_h1']) ?></h1>
						
						<?php if ($mainProduct): ?>
							<article class="article">
								<?= $mainProduct->body ?>
							</article>
						<?php endif; ?>
						
						<?php //if($cat_children AND count($cat_children)>0):?>
							<!--<div class="cat-link">
								<?php //foreach($cat_children as $key => $cat_children_item): ?>
									<?php //if($key):?><br><?php //endif; ?><a href="<?//= Data::_('lang_uri') ?>/products/<?//= $cat_children_item['alias'] ?>" class="cat-link__a"><?//= $cat_children_item['descriptions'][Data::_('lang_id')]['title'] ?></a>
								<?php //endforeach; ?>
							</div>-->
						<?php //endif; ?>
					</div>
					<div class="shop-products-area">
						<!-- Nav tabs -->
						<!--<div class="toolbar">
							<ul role="tablist">
								<li role="presentation" class="first active">
									<a href="#grid-view" aria-controls="grid-view" role="tab"
										data-toggle="tab"><i class="fa fa-th-large"></i></a>
								</li>
								<li role="presentation">
									<a href="#list-view" aria-controls="list-view" role="tab" data-toggle="tab"><i class="fa fa-th-list"></i></a>
								</li>
							</ul>
							<div class="limiter toolbar-sorter">
								<label class="label" for="sorter">Sort By</label>
								<div class="control">
									<select id="sorter">
										<option value="position" selected="selected">Position</option>
										<option value="name">Name</option>
										<option value="price">Price</option>
									</select>
								</div>
							</div>
							<div class="limiter">
								<label class="label" for="limiter">Show</label>
								<div class="control">
									<select id="limiter">
										<option value="9" selected>9</option>
										<option value="15">15</option>
										<option value="30"> 30</option>
									</select>
								</div>
							</div>
						</div>-->
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="grid-view">
								<div class="row">
								
									<?php if($product): ?>
									
										<div class="shop-products" id="listView">

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
																<?= BuyButton::widget([
																	'model' => $item,
																	'text' => '<i class="fa fa-cart-plus" aria-hidden="true"></i>',
																	'htmlTag' => 'a',
																	'cssClass' => ''
																]) ?>
																<!--<a onclick="addToCart('<?= $item->id ?>', 'products');" title="Добавить в корзину"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
																<a onclick="addToFav('<?= $item->id ?>');" title="Отложить"><i class="fa fa-star-o" aria-hidden="true"></i></a>-->
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
											
										</div>
										
										<?php if ($dataProvider->totalCount > $dataProvider->pagination->pageSize): ?>
											<a href="#" id="showMore" class="button-more">Показать еще <img src="/img/loader.gif" alt="" class="loading" style="display:none;"></a>
											<script type="text/javascript">
											/*<![CDATA[*/
												(function($)
												{
													// запоминаем текущую страницу и их максимальное количество
													var page = parseInt('<?php echo (int)Yii::$app->request->getQueryParam('page', 1); ?>');
													var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');
										 
													var loadingFlag = false;
										 
													$('#showMore').click(function()
													{
														// защита от повторных нажатий
														if (!loadingFlag)
														{
															// выставляем блокировку
															loadingFlag = true;
															
															page = page + 1;
															
															// отображаем анимацию загрузки
															$('.loading').show();
										 
															$.ajax({
																type: 'post',
																url: window.location.href,
																data: {
																	// передаём номер нужной страницы методом POST
																	'page': page
																},
																success: function(data)
																{
																	// увеличиваем номер текущей страницы и снимаем блокировку
																	//page++;                            
																	loadingFlag = false;                            
										 
																	// прячем анимацию загрузки
																	$('.loading').hide();
										 
																	// вставляем полученные записи после имеющихся в наш блок
																	$('#listView').append(data);
										 
																	// если достигли максимальной страницы, то прячем кнопку
																	if (page >= pageCount){
																		$('#showMore').hide();
																	}
																}
															});
														}
														return false;
													})
												})(jQuery);
											/*]]>*/
											</script>
										<?php endif; ?>
									
									<?php else: ?>
										<div class="section-title section-title-shop">
											<h2>Извините, по вашему запросу ничего не найдено.</h2>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>