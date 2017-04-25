<?php

use yii\helpers\Html;
use app\modules\infoblock\components\BlockText;
use app\modules\catalog\components\BlockCatalog;

$this->title = $message;
$this->params['page_class'] = 'page-404';
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
				<h1><?= Html::encode($message) ?></h1>
				<?= BlockText::_('block_404') ?>
			</div>
		</div>
	</div>
</div>