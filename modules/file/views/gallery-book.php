<?php
use app\modules\file\components\Img;
?>

<?php if($content->files):?>
	<div class='book'>
		<div id='js-book'>
			<?php foreach($content->files as $file):?>
				<div class='book__page'>
					<img src="<?= Img::_($moduleImageDir, $content->id, 'vertical-large', $file->filename) ?>" alt="<?= $file->alt ?>" title="<?= $file->title ?>">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>