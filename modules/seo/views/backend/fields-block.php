<div class="row">
	<div class="col-xs-12 col-md-12">

		<label><?= $blockTitle ?></label>

		<div class="form-group">
			<label class="control-label">Заголовок H1</label>
			<input type="text" class="form-control" name="Seo[title_h1]" value="<?= $data['title_h1'] ?>">
		</div>
		
		<?php if($is_main_event):?>
			<div class="form-group">
				<label class="control-label">Заголовок H1(архив)</label>
				<input type="text" class="form-control" name="Seo[title_h12]" value="<?= $data['title_h12'] ?>">
			</div>
			<hr>
		<?php endif;?>

		<div class="form-group">
			<label class="control-label">Meta Title</label>
			<input type="text" class="form-control" name="Seo[meta_title]" value="<?= $data['meta_title'] ?>">
		</div>
		
		<?php if($is_main_event):?>
			<div class="form-group">
				<label class="control-label">Meta Title(архив)</label>
				<input type="text" class="form-control" name="Seo[meta_title2]" value="<?= $data['meta_title2'] ?>">
			</div>
			<hr>
		<?php endif;?>

		<div class="form-group">
			<label class="control-label">Meta Keywords</label>
			<textarea class="form-control" name="Seo[meta_key]" rows="6"><?= $data['meta_key'] ?></textarea>
		</div>
		
		<?php if($is_main_event):?>
			<div class="form-group">
				<label class="control-label">Meta Keywords(архив)</label>
				<textarea class="form-control" name="Seo[meta_key2]" rows="6"><?= $data['meta_key2'] ?></textarea>
			</div>
			<hr>
		<?php endif;?>

		<div class="form-group">
			<label class="control-label">Meta Description</label>
			<textarea class="form-control" name="Seo[meta_desc]" rows="6"><?= $data['meta_desc'] ?></textarea>
		</div>
		
		<?php if($is_main_event):?>
			<div class="form-group">
				<label class="control-label">Meta Description(архив)</label>
				<textarea class="form-control" name="Seo[meta_desc2]" rows="6"><?= $data['meta_desc2'] ?></textarea>
			</div>
		<?php endif;?>
	</div>
</div>