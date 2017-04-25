<?php
use yii\helpers\Html;
use app\modules\file\components\Img;
use app\components\helpers\Text;
?>
<?php if(!empty($data) && $is_content):?>
	<section class="cont">
	
		<h2 class="h-main"><?= Html::encode($titleBlock) ?></h2>
		<div class="line">
		
			<?php $count = count($data); foreach($data as $item):?>
				<?php if($item['content']):?>
					<div class="product">
						<a href="/<?= $item['linkModule'] ?>/<?= $item['content']->alias ?>" class="convex">
							<div class="convex__gor">
								<div class="convex__vert">
									<?php if($item['content']->thumb):?>
										<img src="<?= Img::_($item['type'], $item['content']->id, 'big-square', $item['content']->thumb->filename) ?>" alt=""> <!-- 208X208 -->
									<?php endif; ?>
								</div>
							</div>
						</a>
						<div class="product__content">
						
							<a href="/<?= $item['linkModule'] ?>/<?= $item['content']->alias ?>"><?= $item['content']->title ?></a><br>
							
							<?php if($item['type'] == 'event'):?>
								<b><?= Text::_date($item['content']->date, '.', ' ', ' года')?></b>
								<?php if ($item['content']->date > date('Y-m-d')): ?>
									<a class="button" onclick="addOrderEvent(<?= $item['content']->id ?>, '<?= htmlspecialchars($item['content']->title) ?>', '<?= $item['content']->text1 ?>');">Записаться</a>
								<?php endif; ?>
							<?php elseif($item['type'] == 'product'):?>
								<b><?= $item['content']->price ?> р.</b>
								<?php if(!$item['content']->is_not):?>
									<a onclick="addOrderProduct(<?= $item['content']->id ?>, '<?= htmlspecialchars($item['content']->title) ?>', '<?= $item['content']->price ?>');" class="button">Купить</a>
								<?php else: ?>
									<a class="button button_light">нет в наличии</a>
								<?php endif; ?>
							<?php elseif($item['type'] == 'training'):?>
								<!--<b><?//= Text::_date($item['content']->project_start, '.', ' ', ' года')?></b>-->
								<?php //if ($item['content']->project_start > date('Y-m-d')): ?>
									<a class="button" onclick="addOrderTraining(<?= $item['content']->id ?>, '<?= htmlspecialchars($item['content']->title) ?>', '<?= $item['content']->text1 ?>');">Записаться</a>
								<?php //endif; ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		  
		</div>
		<?php if($count > 4): ?>
			<a href="#" class="button-more js-button-more">Показать еще</a>
		<?php endif; ?>
	</section>
<?php endif; ?>
