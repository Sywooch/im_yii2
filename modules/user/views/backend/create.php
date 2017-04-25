<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Новая запись';
$this->params['breadcrumbs'][] = ['label' => 'Аккаунт', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h3><?= Html::encode($this->title) ?></h3>

	<hr>

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

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4">
			<?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">

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
        <div class="col-sx-12 col-md-12">
			<div class="form-group pd-top-25">
                <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

	<?php ActiveForm::end(); ?>
</div>
