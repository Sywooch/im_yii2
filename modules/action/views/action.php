<?php

use yii\helpers\Html;
use app\modules\action\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
use app\components\widgets\Related;

use app\components\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $action->title;
$this->params['page_class'] = 'page-action';
?>
<section class="cont cont-article">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<h1 class="h-main"><?= Html::encode($action->title) ?></h1>
	
	<div class="flex-article">
		<div class="flex-article__left">
			<div class="to-left">
				<?= Text::_edit($action->id, 'action') ?> <!-- Ссылка на редактирование материала -->
			</div>
			
			<article class="article article_wide">
				<?= $action->body ?>
			</article>
		</div>
		
		<div class="flex-article__right">
			<?php if($action->thumb):?>
				<div class="flex-article__row">
					<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $action->id, 'large', $action->thumb->filename) ?>" alt="<?= $action->title?>" title="<?= $action->title?>">
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ($action->files): ?>
	<section class="cont">
		<div class="swiper-carousel">
			<div class="swiper-button-next js-carousel-next"></div>
			<div class="swiper-button-prev js-carousel-prev"></div>
			<div class="swiper-container js-carousel">
				<div class="swiper-wrapper">
				
					<?php foreach($action->files as $file):?>
						<div class="swiper-slide">
							<a href="<?= Img::_(Module::getInstance()->imagesDirectory, $action->id, 'vertical-large', $file->filename) ?>" class="js-popup"><img src="<?= Img::_(Module::getInstance()->imagesDirectory, $action->id, 'middle-square', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>"></a>
						</div>
					<?php endforeach; ?>
					
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?= Related::_($action, 'Возможно, также вас заинтересует:') ?>