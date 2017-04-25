<?php

use yii\widgets\ActiveForm;
use app\modules\file\components\Img;

?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<label><?= $blockTitle ?></label>
		<?php if($model->{$link} AND !empty($model->{$link})):?>
			<div class="row">
				<?php foreach($model->{$link} as $file):?>
					<div class="gall-image-item col-xs-12 col-md-2" id="<?= $moduleImageDir ?>_<?= $model->id ?>_<?= $file->id ?>_imageblock">
						<a onclick="deleteImage('<?= $moduleImageDir ?>', '<?= $model->id ?>', '<?= $file->filename ?>', '<?= $file->id ?>');" class="thumbnail" data-toggle="tooltip" data-placement="top" title="Удалить это изображение">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							<img src="<?= Img::_($moduleImageDir, $model->id, $size, $file->filename) ?>">
						</a>
						
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<div class="form-group form-group-mini">
									<label>delta</label>
									<input type="text" class="form-control" name="imageAttr[<?= $file->id ?>][delta]" value="<?= $file->delta ?>">
								</div>
							</div>	
							<div class="col-xs-12 col-md-9">
								<div class="form-group form-group-mini">
									<label>alt</label>
									<input type="text" class="form-control" name="imageAttr[<?= $file->id ?>][alt]" value="<?= $file->alt ?>">
								</div>
							</div>	
						</div>						
						<div class="form-group form-group-mini">
							<label>title</label>
							<input type="text" class="form-control" name="imageAttr[<?= $file->id ?>][title]" value="<?= $file->title ?>">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		<hr>
		<?= $form->field($model, $formName)->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
	</div>
</div>