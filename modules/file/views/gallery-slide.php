<?php
use app\modules\file\components\Img;
?>

<?php if($content->files):?>
	<div class="article__full-width">
		<div class="swiper-gal swiper-controls">
			<div class="swiper-button-prev swiper-gal__prev"></div>
			<div class="swiper-button-next swiper-gal__next"></div>
			<div class="js-gal swiper-container">
				<div class="swiper-wrapper">
					<?php foreach($content->files as $file):?>
						<a href="<?= Img::_($moduleImageDir, $content->id, 'extralarge', $file->filename) ?>" title="<?= $file->title ?>" class="swiper-slide img-popup">
							<img src="<?= Img::_($moduleImageDir, $content->id, 'middle-square', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>">
							<h4><?= $file->title ?></h4>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>