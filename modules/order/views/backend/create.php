<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\order\Module;

use app\modules\order\models\Order;
use kartik\date\DatePicker;

$this->title = 'Создание нового заказа';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="<?= Module::getInstance()->id ?>-form">

		<hr>
		
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-success']) ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-6">
				<label class="control-label" for="article-date">Дата заказа</label>
				<?= DatePicker::widget([
					'name' => 'Order[date]',
					'value' => $model->date,
					'options' => ['placeholder' => 'Выберите дату ...'],
					'pluginOptions' => [
						'format' => 'yyyy-mm-dd',
						'todayHighlight' => true
					]
				]); ?><br>
				
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div class="col-xs-12 col-md-6">
				<?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
				
				<?= $form->field($model, 'shipping')->radioList(ArrayHelper::map($shippingMethods, 'id', 'title')) ?>
				<?= $form->field($model, 'payment')->radioList(ArrayHelper::map($paymentMethods, 'id', 'title')) ?>
				<?= $form->field($model, 'status')->dropDownList(Order::getStatusArray()) ?>
				<?= $form->field($model, 'type')->dropDownList(Order::getTypeArray()) ?>
			</div>
		</div>
		
		<hr>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-success']) ?>
				</div>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
