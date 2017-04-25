<?php
use yii\helpers\Html;
use app\modules\action\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;
?>
<?php if ($actions): ?>
	<?php foreach($actions as $item): ?>
		<div class="program__item">
			<?= Text::_edit($item->id, 'action') ?> <!-- Ссылка на редактирование материала -->
			<a href="/actions/<?= $item->alias ?>" class="convex">
				<div class="convex__gor">
					<div class="convex__vert">
						<?php if($item->thumb):?>
							<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $item->id, 'middle-square', $item->thumb->filename) ?>"> <!-- 230X230 -->
						<?php endif; ?>
					</div>
				</div>
			</a>
			<div class="program__content">
				<h3 class="program__header"><a href="/actions/<?= $item->alias ?>"><?= $item->short_title ?></a></h3>
				<div class="program__date"><?= Text::_date($item->date, '.', ' ', ' года')?></div>
				<div class="program__text">
					<?= $item->teaser ?>
				</div>
			</div>
			<a class="button" onclick="addOrderAction(<?= $item->id ?>, '<?= htmlspecialchars($item->short_title) ?>');">Участвовать в акции</a>
		</div>
	<?php endforeach; ?>
<?php endif; ?>