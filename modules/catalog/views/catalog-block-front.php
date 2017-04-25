<?php

use yii\helpers\Html;
use app\modules\file\components\Img;
use app\components\helpers\Text;

?>
<?php if ($catalog): ?>
	<div class="shop-products-area">
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="grid-view">
				<div class="row">
					<div class="shop-products">
						<?php foreach($catalog as $item): ?>
						
							<div class="col-md-4">
								<div class="product-wrapper first category-item">
									<?= Text::_edit($item->id, 'catalog') ?> <!-- Ссылка на редактирование материала -->
									<div class="product-img">
										<a href="/cat/<?= $item->alias ?>">
											<img src="<?= Img::_('catalog', $item->id, 'original', $item->thumb->filename) ?>" alt="">
										</a>
									</div>
									<div class="product-content category-content">
										<div class="section-title">
											<h3><a href="/cat/<?= $item->alias ?>"><?= $item->short_title ?></a></h3>
										</div>
									</div>
								</div>
							</div>
							
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>