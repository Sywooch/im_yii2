<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\order\Module;

use app\modules\order\models\Order;
use kartik\date\DatePicker;

use yii\grid\GridView;
use app\components\widgets\backend\grid\EditColumn;

$this->title = 'Редактировать: ' . ' Заказ №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №'.$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="order-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="<?= Module::getInstance()->id ?>-form">
	
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<?php //$formAddOrderProduct = ActiveForm::begin(['action' => '/admin/' . Module::getInstance()->id . '/orderProduct-create-fast']); ?>
				<!--<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-3">
						<h3>Товары</h3>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-5">
						<?//= Html::hiddenInput('OrderProduct[order_id]', $model->id) ?>
						<?//= $formAddOrderProduct->field($newOrderProductModel, 'product_title')->textInput(['maxlength' => true]) ?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="form-group pd-top-25">
							<?//= Html::submitButton('Добавить товар в заказ', ['class' => 'btn btn-success']) ?>
						</div>
					</div>
				</div>
				<?php //ActiveForm::end(); ?>
				
				<hr>-->

				<p>
					<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
				</p>

				<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/orderProduct-multi-action', 'post', ['id' => 'update_form']) ?>
				<?= Html::hiddenInput('order_id', $model->id) ?>
				<?= GridView::widget([
					'dataProvider' => $orderProductModel,
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],
						['class' => 'yii\grid\CheckboxColumn'],
						[
							'class' => EditColumn::className(),
							'attribute' => 'product_title',
						],
						[
							'class' => EditColumn::className(),
							'attribute' => 'product_code',
						],
						[
							'class' => EditColumn::className(),
							'attribute' => 'product_option',
						],
						[
							'class' => EditColumn::className(),
							'attribute' => 'product_price',
						],
						[
							'class' => EditColumn::className(),
							'attribute' => 'product_qty',
						],
						'product_total',
						[
							'class' => 'yii\grid\ActionColumn',
							'template' => '<p class="text-right">{delete}</p>',
							'buttons' => [
								'delete' => function ($url, $model, $key) {
									$buttonOption = [
										'title' => Yii::t('yii', 'Delete'),
										'aria-label' => Yii::t('yii', 'Delete'),
										'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
										'data-method' => 'post',
										'data-pjax' => '0',
									];
									return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['orderProduct-delete', 'id' => $key]), $buttonOption);
								}
							]
						],
					],
				]); ?>
				<?= Html::endForm(); ?>
			</div>
		</div>

		<hr>

		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
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
				<?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		
		<hr>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="form-group">
					<?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
				</div>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
