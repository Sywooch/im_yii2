<?php

use app\modules\infoblock\components\BlockText;
use app\components\helpers\Text;
use app\modules\catalog\components\BlockCatalog;
use app\modules\banner\components\BlockBanner;

$this->params['page_class'] = 'page-index';
?>
<?= BlockBanner::_() ?>
<!--/home-area-->

<div class="block-ground ptb-30">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<!-- home-two-menu -->
				<?= BlockCatalog::left() ?>
			
				<div id="recently_block" class="ptb-30"></div>
			</div>
			
			<div class="col-md-9">
				<div class="top-block top-block6">
					<?= BlockCatalog::front() ?> <!-- Категории в виде блоков -->
				</div>
				
				<?= Text::_edit($this->params['siteinfo']->id, 'main') ?> <!-- Ссылка на редактирование материала -->
				<h1 class="h-main"><?= $this->params['siteinfo']->slogan ?></h1>
				<?= $this->params['siteinfo']->body ?>
			</div>	
		</div>
	</div>
</div>
<!--/block-ground-->