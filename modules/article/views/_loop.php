<?php
use yii\helpers\Html;
use app\modules\article\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
?>
<?php if ($articles): ?>
	<?php foreach($articles as $item): ?>
		<div class="program__item">
			<?= Text::_edit($item->id, 'article') ?> <!-- Ссылка на редактирование материала -->
			<a href="/articles/<?= $item->alias ?>" class="convex">
				<div class="convex__gor">
					<div class="convex__vert">
						<?php if($item->thumb):?>
							<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $item->id, 'middle-square', $item->thumb->filename) ?>"> <!-- 230X230 -->
						<?php endif; ?>
					</div>
				</div>
			</a>
			<div class="program__content">
				<h3 class="program__header"><a href="/articles/<?= $item->alias ?>"><?= $item->short_title ?></a></h3>
				<div class="program__date"><?= Text::_date($item->date, '.', ' ', ' года')?></div>
				<div class="program__text">
					<?= $item->teaser ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>