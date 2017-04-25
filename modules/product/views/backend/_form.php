<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use vova07\imperavi\Widget;

use app\modules\file\components\Img;
use app\modules\seo\components\Seo;
use app\modules\option\models\Option;

use app\components\redactorSetting;
use kartik\date\DatePicker;
use app\modules\product\Module;
?>
<div class="<?= Module::getInstance()->id ?>-form">
	<hr>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'status')->checkbox() ?>
		</div>
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'is_not')->checkbox() ?>
		</div>
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'is_new')->checkbox() ?>
		</div>
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'is_sale')->checkbox() ?>
		</div>
		<div class="col-xs-6 col-md-2">
			<?= $form->field($model, 'is_hit')->checkbox() ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-md-8">
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<?php echo Collapse::widget([
						'items' => [
							[
								'label' => 'Взаимосвязи с другими материалами',
								'content' => '<div class="row">
												<div class="col-xs-12 col-md-12">'
													.$form->field($model, 'attach_title')->textInput(['maxlength' => true]).
												'</div>
												<div class="col-xs-6 col-md-4">'
													.$form->field($model, 'productsArray')->dropDownList(ArrayHelper::map($productItems, 'id', 'title'), ['size' => 6, 'multiple' => true, 'prompt' => '.. нет ..', 'options' => [$model->id => ['disabled' => true]]]).
												'</div>
												<div class="col-xs-6 col-md-4">'
													.$form->field($model, 'catalogArray')->dropDownList(ArrayHelper::map($catalogItems, 'id', 'title'), ['size' => 6, 'multiple' => true, 'prompt' => '.. нет ..']).
												'</div>
												<div class="col-xs-6 col-md-4">'
													.$form->field($model, 'actionsArray')->dropDownList(ArrayHelper::map($actionItems, 'id', 'title'), ['size' => 6, 'multiple' => true, 'prompt' => '.. нет ..']).
												'</div>
											</div>',
							]
						]
					]); ?>
				</div>
			</div>
			
			<hr>
			
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label(Module::t('module', 'PRODUCT_BACK_FORM_ALIAS_AND_COMMENT')) ?>
				</div>
				<div class="col-xs-12 col-md-4">
					<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
				</div>
				
				<div class="col-xs-12 col-md-4">
					<label>Главная картинка(иконка)</label>
					<?php if($model->thumb):?>
						<div class="row">
							<div class="col-xs-12 col-md-12" id="<?= Module::getInstance()->imagesDirectory ?>_<?= $model->id ?>_<?= $model->thumb->id ?>_imageblock">
								<a onclick="deleteImage('<?= Module::getInstance()->imagesDirectory ?>', '<?= $model->id ?>', '<?= $model->thumb->filename ?>', '<?= $model->thumb->id ?>');" class="thumbnail" data-toggle="tooltip" data-placement="top" title="Удалить это изображение">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
									<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename) ?>">
								</a>
							</div>
						</div>
					<?php endif; ?>
					<?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>
				</div>
			</div>
			
			<hr>
			
			<?php echo Collapse::widget([
				'items' => [
					[
						'label' => 'Фотогалерея',
						'content' => Img::_galleryView(Module::getInstance()->imagesDirectory, $model, $form, 'thumbgall', 'files', 'imageGallery[]', 'Фотогалерея')
					]
				]
			]); ?>
				
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<?= $form->field($model, 'teaser')->textarea(['rows' => 6])->widget(Widget::className(), [
						'settings' => redactorSetting::_($model->id, Module::getInstance()->id)
					]); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<?= $form->field($model, 'body')->textarea(['rows' => 6])->widget(Widget::className(), [
						'settings' => redactorSetting::_($model->id, Module::getInstance()->id)
					]); ?>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-md-4">
			<div class="row">
				<?php if(!$model->isNewRecord):?>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3>Характеристики</h3>
						<p>
							<a class="btn btn-success btn-xs" href="/admin/feature/create?content_id=<?= $model->id ?>&module=<?= Module::getInstance()->id ?>">Добавить характеристику</a>
						</p>
						
						<table id="w1" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Характеристика</th>
									<th>Значение</th>
									<th class="action-column">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php if($features):?>
									<?php foreach($features as $key => $feature):?>
										<tr class="treegrid-1" data-key="<?= $key+1 ?>">
											<td><span class="treegrid-expander"></span><?= $key+1 ?></td>
											<td><?= $feature->name ?></td>
											<td><?= $feature->value ?></td>
											<td>
												<p class="text-right">
													<a href="/admin/feature/update?id=<?= $feature->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
													<a href="/admin/feature/delete?id=<?= $feature->id ?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
												</p>
											</td>
										</tr>
									<?php endforeach;?>
								<?php else: ?>
									<tr>
										<td colspan="4"><h5>Нет характеристик</h5></td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3>Опции</h3>
						<p>
							<a class="btn btn-success btn-xs" href="/admin/option/create?content_id=<?= $model->id ?>&module=<?= Module::getInstance()->id ?>">Добавить опцию</a>
						</p>
						
						<?php if(!empty($options)):?>
							<?php foreach($options as $typeId => $oneTypeOptions):?>
								<?php if($oneTypeOptions):?>
								
									<h3><?= Option::getOptionTypeName($typeId) ?></h3>
									
									<table id="w1" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>#</th>
												<th>Опция</th>
												<th>Стоимость с опцией</th>
												<th class="action-column">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($oneTypeOptions as $key => $option):?>
												<tr class="treegrid-1" data-key="<?= $key+1 ?>">
													<td>
														<?php if($option->thumb):?>
															<img src="<?= Img::_('option', $option->id, 'icon', $option->thumb->filename)?>">
														<?php endif; ?>
													</td>
													<td><?= $option->name ?></td>
													<td><?= $option->price ?></td>
													<td>
														<p class="text-right">
															<a href="/admin/option/update?id=<?= $option->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
															<a href="/admin/option/delete?id=<?= $option->id ?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
														</p>
													</td>
												</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								<?php endif; ?>
							<?php endforeach;?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
		<div class="col-xs-4 col-md-2">
			<div class="form-group">
				<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>
		<div class="col-xs-8 col-md-10">
			<?php echo Collapse::widget([
				'items' => [
					[
						'label' => 'SEO',
						'content' => Seo::_fieldsView($model)
					]
				]
			]); ?>
		</div>
	</div>
    <?php ActiveForm::end(); ?>
</div>