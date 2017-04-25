<?php

use yii\helpers\Html;
use app\modules\file\components\Img;
use app\modules\infoblock\components\BlockText;
use app\components\widgets\Breadcrumbs;
use app\components\helpers\Text;

$this->params['breadcrumbs'][] = $this->title;
$this->params['page_class'] = 'page-action';
?>
<section class="cont">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<h1 class="h-main"><?= Html::encode($this->title) ?></h1>
</section>
<?php if ($search && !empty($search)): ?>
	<?php foreach($search as $moduleTitle => $content): ?>
		<section class="program program_light">
			<a href="<?= $content['link'] ?>" class="button-more button-more_top"><?= Html::encode($moduleTitle) ?></a>
			<div class="cont program__flex">
				<?php foreach($content['content'] as $item): ?>
					<div class="program__item">
						<a href="<?= $content['link'] ?><?php if($content['is_id']): ?><?= $item->id ?><?php else: ?><?= $item->alias ?><?php endif; ?>" class="convex">
							<div class="convex__gor">
								<div class="convex__vert">
									<?php if($item->thumb):?>
										<img src="<?= Img::_($content['module'], $item->id, 'middle-square', $item->thumb->filename) ?>"> <!-- 230X230 -->
									<?php endif; ?>
									<!--<div class="convex__price"></div>-->
								</div>
							</div>
						</a>
	
						<div class="program__content">
							<h3 class="program__header"><a href="<?= $content['link'] ?><?php if($content['is_id']): ?><?= $item->id ?><?php else: ?><?= $item->alias ?><?php endif; ?>"><?= $item->title ?></a></h3>
							<?php if($content['is_date']): ?><div class="program__date"><?= Text::_date($item->date, '.', ' ', ' г.')?></div><?php endif; ?>
							<div class="program__text">
								<?= $item->teaser ?>
							</div>
						</div>
						<a href="<?= $content['link'] ?><?php if($content['is_id']): ?><?= $item->id ?><?php else: ?><?= $item->alias ?><?php endif; ?>" class="button js-popup-inline">подробнее</a>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endforeach; ?>
<?php else: ?>
	<section class="program program_light">
		<div class="cont program__flex">
			<h2>Извините, по Вашему запросу ничего не найдено. Попробуйте уточнить искомое слово(а).</h2>
		</div>
	</section>
<?php endif; ?>