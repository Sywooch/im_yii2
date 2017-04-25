<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\file\components\Img;
?>
<?php if ($content): ?>
	<div class="pt-10"> <!-- pt-10 pb-10 -->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="slider-container slider-container6">
						<div id="mainSlider" class="nivoSlider slider-image">
							<?php foreach($content as $item): ?>
								<?php if(!empty($item->text_block2)): ?>
									<a href="<?= $item->text_block2 ?>"><img src="<?= Img::_('slider', $item->id, 'full-width', $item->thumb->filename) ?>" alt=""></a>
								<?php else: ?>
									<img src="<?= Img::_('slider', $item->id, 'full-width', $item->thumb->filename) ?>" alt="">
								<?php endif; ?>
								
								<?php //if(!empty($item->text_block1)):?>
									<?//= $item->text_block1 ?>
								<?php //endif;?>
								
								<?php //if(!empty($item->text_block3)):?>
									<?//= $item->text_block3 ?>
								<?php //endif;?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>