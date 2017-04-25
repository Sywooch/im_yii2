<?php

use yii\helpers\Html;
use app\modules\file\components\Img;

?>
<?php if ($product): ?>
	<h2 class="h h_primary">
		<span class="h__text"><?= Html::encode($titleBlock) ?></span>
	</h2>

	<div class="masonry masonry_client clearfix">
		<div class="masonry__gutter"></div>
		
		<?php foreach($product as $item): ?>
			<div class="masonry__item">
				<div class="masonry__content">
					<?php if($item->thumb):?>
						<a href="/product/<?= $item->alias ?>" class="masonry__logo"><img src="<?= Img::_('product', $item->id, 'big', $item->thumb->filename) ?>" alt="<?= $item->thumb->alt ?>"></a>	
					<?php endif; ?>
					<h3 class="masonry__header"><a href="/product/<?= $item->alias ?>"><?= $item->title ?></a></h3>
					<div class="masonry__text">
						<?= $item->teaser ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>