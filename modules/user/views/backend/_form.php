<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sx-12 col-md-2">
            <div class="form-group pd-top-25">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <?= $form->field($model, 'status')->dropDownList(User::getStatusesArray()) ?>
        </div>
        <div class="col-xs-6 col-md-8">

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description')) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
	
	<h3>Профиль пользователя</h3>
	<hr>
	<?php //echo Collapse::widget([
		//'items' => [
		//	[
		//		'label' => 'Фото',
		//		'content' => Img::_galleryView('profile', $profileModel, $form, 'thumbgall', 'files', 'imageGallery[]', 'Фото')
		//	]
		//]
	//]); ?>
	<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
			<?= $form->field($profileModel, 'lastname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($profileModel, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($profileModel, 'phathername')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
			<?= $form->field($profileModel, 'phone')->textInput(['maxlength' => true]) ?>
			<?= $form->field($profileModel, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($profileModel, 'sale')->textInput(['maxlength' => true]) ?>
			<?= $form->field($profileModel, 'sub')->checkbox() ?>
			<?//= $form->field($profileModel, 'age')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
	
	<hr>
	
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
			<h3>Адреса пользователя</h3>
			<p>
				<a class="btn btn-success btn-xs" href="/admin/address/create?user_id=<?= $model->id ?>">Добавить адрес</a>
			</p>
			
			<table id="w1" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Наименование</th>
						<th>Город</th>
						<th>Адрес</th>
						<th class="action-column">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php if($model->addresses):?>
						<?php foreach($model->addresses as $key => $address):?>
							<tr class="treegrid-1" data-key="<?= $key+1 ?>">
								<td><span class="treegrid-expander"></span><?= $key+1 ?></td>
								<td><?= $address->title ?></td>
								<td><?= $address->city ?></td>
								<td><?= $address->address ?></td>
								<td>
									<p class="text-right">
										<a href="/admin/address/update?id=<?= $address->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
										<a href="/admin/address/delete?id=<?= $address->id ?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
					<?php else: ?>
						<tr>
							<td colspan="5"><h5>Нет адресов</h5></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
			<h3>Организации пользователя</h3>
			<p>
				<a class="btn btn-success btn-xs" href="/admin/company/create?user_id=<?= $model->id ?>">Добавить организацию</a>
			</p>
			
			<table id="w1" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Наименование организации</th>
						<th>ИНН</th>
						<th class="action-column">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php if($model->companies):?>
						<?php foreach($model->companies as $key => $company):?>
							<tr class="treegrid-1" data-key="<?= $key+1 ?>">
								<td><span class="treegrid-expander"></span><?= $key+1 ?></td>
								<td><?= $company->company ?></td>
								<td><?= $company->inn ?></td>
								<td>
									<p class="text-right">
										<a href="/admin/company/update?id=<?= $company->id ?>" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
										<a href="/admin/company/delete?id=<?= $company->id ?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
					<?php else: ?>
						<tr>
							<td colspan="4"><h5>Нет организаций</h5></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
        </div>
    </div>
	
	<hr>
	<div class="row">
        <div class="col-sx-12 col-md-12">
			<div class="form-group pd-top-25">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
