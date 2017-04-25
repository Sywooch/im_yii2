<?php
use yii\helpers\Html;
use app\modules\review\Module;
use app\modules\file\components\Img;
use app\modules\infoblock\components\BlockText;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="cont cont_bg">
	<h2 class="h h_primary">
		<span class="h__text"><?= Html::encode($this->title) ?></span>
	</h2>
	<?php if ($reviews): ?>
		<div class="masonry masonry_client clearfix">
			<div class="masonry__gutter"></div>
			<?php foreach($reviews as $item): ?>
				<div class="masonry__item">
					<div class="masonry__content">
						<?php if($item->thumb):?>
							<a href="<?= Img::_('review', $item->id, 'extralarge', $item->thumb->filename) ?>" class="masonry__logo js-popup"><img src="<?= Img::_(Module::getInstance()->id, $item->id, 'mini', $item->thumb->filename) ?>"></a> <!-- 200X -->
						<?php endif; ?>
						<h3 class="masonry__header"><a href="<?= Img::_('review', $item->id, 'extralarge', $item->thumb->filename) ?>" class="masonry__logo js-popup"><?= $item->title ?></a></h3>
					</div>
				</div>
			<?php endforeach; ?>			
		</div>
	<?php else: ?>
		<h2>Извините, в этом разделе пока нет материалов.</h2>
	<?php endif; ?>
</section>