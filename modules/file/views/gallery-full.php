<?php
use app\modules\file\components\Img;
?>

<?php if($content->files):?>
	<div class="article__full-width">
		<div class="swiper-big swiper-controls">
			<div class="swiper-button-prev swiper-big__prev"></div>
			<div class="swiper-button-next swiper-big__next"></div>
			<div class="js-slider swiper-slider">
				<div class="swiper-wrapper">
					<?php foreach($content->files as $file):?>
						<div class="swiper-slide">
							<img src="<?= Img::_($moduleImageDir, $content->id, 'full-width', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>">
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="swiper-big__pagination"></div>
		</div>
	</div>
<?php endif; ?>