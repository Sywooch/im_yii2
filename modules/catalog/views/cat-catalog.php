<?php

use yii\helpers\Html;
use app\modules\catalog\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
use app\components\widgets\Related;

use app\components\widgets\CatalogChildItems;
use app\components\widgets\CatalogEndItems;
use app\modules\catalog\components\BlockCatalog;

use app\components\widgets\Breadcrumbs;

if($catInfo1)
{
	$this->params['breadcrumbs'][] = ['label' => 'Каталог услуг', 'url' => ['/cat']];
}
if($catInfo2)
{
	$this->params['breadcrumbs'][] = ['label' => $catInfo1->short_title, 'url' => ['/cat/'.$catInfo1->alias]];
}
if($catInfo3)
{
	$this->params['breadcrumbs'][] = ['label' => $catInfo2->short_title, 'url' => ['/cat/'.$catInfo1->alias.'/'.$catInfo2->alias]];
}
if($catInfo4)
{
	$this->params['breadcrumbs'][] = ['label' => $catInfo3->short_title, 'url' => ['/cat/'.$catInfo1->alias.'/'.$catInfo2->alias.'/'.$catInfo3->alias]];
}
$this->params['breadcrumbs'][] = $catalogInfo->short_title;
$this->params['page_class'] = 'page-action';
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
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				
				<h1><?= Html::encode($this->params['title_h1']) ?></h1>
				
				<?php if ($catalog): ?>
					<?php if (!empty($childItems) && empty($endItems)): ?>
						<div class="catalog-list">
						
							<?= CatalogChildItems::widget([
								'data' => $catalog,
								'url' => $currentParamUrl, // Начальный url
								'parentFieldValue' => $parent,
							]); ?>
							
						</div>
					<?php elseif (empty($childItems) && !empty($endItems)): ?>
						<div class="catalog-list">
						
							<?= CatalogEndItems::widget([
								'data' => $catalog,
								'url' => $currentParamUrl, // Начальный url
								'parentFieldValue' => $parent,
							]); ?>
							
						</div>
					<?php elseif (!empty($childItems) && !empty($endItems)): ?>
						<div class="catalog-list">
						
							<?= CatalogChildItems::widget([
								'data' => $catalog,
								'url' => $currentParamUrl, // Начальный url
								'parentFieldValue' => $parent,
							]); ?>
							
							<?= CatalogEndItems::widget([
								'data' => $catalog,
								'url' => $currentParamUrl, // Начальный url
								'parentFieldValue' => $parent,
							]); ?>
							
						</div>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if ($catalogInfo): ?>
				
					<article class="article">
						<?= Text::_edit($catalogInfo->id, 'catalog') ?> <!-- Ссылка на редактирование материала -->
						<?php if(!empty($catalogInfo->text1)):?>
							<p><b>Стоимость:</b> <?= $catalogInfo->text1 ?></p>
						<?php endif; ?>
						<?= $catalogInfo->body ?>
					</article>
					
					<?php if ($catInfo1->alias == 'treningi-programmy-tvorcheskie-masterklassy'): ?>
						<!--<a href="/training" class="button">Все тренинги</a><br><br>-->
					<?php else: ?>
						<!--<a class="button" onclick="addOrderCatalog(<?//= $catalogInfo->id ?>, '<?//= htmlspecialchars($catalogInfo->short_title) ?>', '');">Записаться</a><br><br>-->
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if ($catalogInfo && $catalogInfo->files): ?>
					<?php foreach($catalogInfo->files as $file):?>
						<div class="swiper-slide">
							<a href="<?= Img::_(Module::getInstance()->imagesDirectory, $catalogInfo->id, 'vertical-large', $file->filename) ?>" class="js-popup"><img src="<?= Img::_(Module::getInstance()->imagesDirectory, $catalogInfo->id, 'middle-square', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>"></a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<?= Related::_($catalogInfo, 'Возможно, также вас заинтересует:') ?>
			</div>
		</div>
	</div>
</div>