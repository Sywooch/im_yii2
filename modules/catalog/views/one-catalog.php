<?php
use yii\helpers\Html;
use app\modules\catalog\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;

use app\modules\catalog\components\BlockCatalog;

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $catalog->short_title;
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
				<?= Text::_edit($catalog->id, 'catalog') ?> <!-- Ссылка на редактирование материала -->
				
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				
				<h1><?= Html::encode($this->params['title_h1']) ?></h1>
				
				<?php //if($catalog->thumb):?>
					<!--<img src="<?//= Img::_(Module::getInstance()->imagesDirectory, $catalog->id, 'middle', $catalog->thumb->filename) ?>" alt="" class="catalog__left">-->	<!-- 400X -->
				<?php //endif; ?>
				<?= $catalog->body ?>
			</div>
		</div>
	</div>
</div>

<section class="cont">
	<?= Text::_edit($catalog->id, 'catalog') ?> <!-- Ссылка на редактирование материала -->
	
	<h1 class="h h_primary">
		<span class="h__text"><?= Html::encode($this->params['title_h1']) ?></span>
	</h1>
	<article class="article">
		<?php //if($catalog->thumb):?>
			<!--<img src="<?//= Img::_(Module::getInstance()->imagesDirectory, $catalog->id, 'middle', $catalog->thumb->filename) ?>" alt="" class="catalog__left">-->	<!-- 400X -->
		<?php //endif; ?>
		<?= $catalog->body ?>
	</article>
</section>