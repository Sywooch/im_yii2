<?php

use yii\helpers\Html;
use app\modules\article\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
use app\components\widgets\Related;

use app\components\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Горячие темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $article->title;
$this->params['page_class'] = 'page-article';
?>
<section class="cont cont-article">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<h1 class="h-main"><?= Html::encode($article->title) ?></h1>
	
	<div class="flex-article">
		<div class="flex-article__left">
			<div class="to-left">
				<?= Text::_edit($article->id, 'article') ?> <!-- Ссылка на редактирование материала -->
			</div>
			
			<article class="article article_wide">
				<?= $article->body ?>
			</article>
		</div>
		
		<div class="flex-article__right">
			<?php if($article->thumb):?>
				<div class="flex-article__row">
					<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $article->id, 'large', $article->thumb->filename) ?>" alt="<?= $article->title?>" title="<?= $article->title?>">
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ($article->files): ?>
	<section class="cont">
		<div class="swiper-carousel">
			<div class="swiper-button-next js-carousel-next"></div>
			<div class="swiper-button-prev js-carousel-prev"></div>
			<div class="swiper-container js-carousel">
				<div class="swiper-wrapper">
				
					<?php foreach($article->files as $file):?>
						<div class="swiper-slide">
							<a href="<?= Img::_(Module::getInstance()->imagesDirectory, $article->id, 'vertical-large', $file->filename) ?>" class="js-popup"><img src="<?= Img::_(Module::getInstance()->imagesDirectory, $article->id, 'middle-square', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>"></a>
						</div>
					<?php endforeach; ?>
					
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?= Related::_($article, 'Возможно, также вас заинтересует:') ?>