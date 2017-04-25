<?php
use yii\helpers\Html;
use app\modules\catalog\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
use app\components\widgets\CatalogChildItems;
use app\modules\catalog\components\BlockCatalog;

use app\components\widgets\Breadcrumbs;

if($catInfo1)
{
	$this->params['breadcrumbs'][] = ['label' => 'Каталог услуг', 'url' => ['/catalogs']];
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
$this->params['breadcrumbs'][] = $this->params['title_h1'];
$this->params['page_class'] = 'page-catalog';
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
					<div class="cat">
						<?= CatalogChildItems::widget([
							'data' => $catalog,
							'url' => $currentParamUrl, // Начальный url
							'parentFieldValue' => $parent,
						]); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>