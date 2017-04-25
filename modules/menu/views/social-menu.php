<?php if($menu): ?>
	<?php foreach($menu as $value): ?>
		<li>
			<a href="<?= $value->url ?>" target="blank" title="<?= $value->title ?>"><i class="fa fa-'<?= $value->icon ?>"></i></a>
		</li>
	<?php endforeach; ?>
<?php endif; ?>