<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use yii\grid\GridView;
use kartik\date\DatePicker;
use app\components\widgets\backend\grid\RoleColumn;

use app\modules\user\Module;

$this->title = 'Аккаунт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
		<?= Html::button('Сохранить изменения', ['class' => 'btn btn-warning btn-xs right', 'onclick' => 'multiUpdate("update_form")']) ?>
    </p>
	<?= Html::beginForm('/admin/' . Module::getInstance()->id . '/multi-action', 'post', ['id' => 'update_form']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			['class' => 'yii\grid\CheckboxColumn'],

            [
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'date_from',
					'attribute2' => 'date_to',
					'type' => DatePicker::TYPE_RANGE,
					'separator' => '-',
					'pluginOptions' => ['format' => 'yyyy-mm-dd']
				]),
				'attribute' => 'created_at',
				'format' => 'date',
			],

            'username',
            'email:email',
			[
				'class' => RoleColumn::className(),
				'filter' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
				'attribute' => 'role',
			],
            [
				'filter' => User::getStatusesArray(),
				'attribute' => 'status',
				'format' => 'raw',
				'value' => function ($model, $key, $index, $column) {
					$value = $model->{$column->attribute};
					switch ($value) {
						case User::STATUS_ACTIVE:
							$class = 'success';
							break;
						case User::STATUS_WAIT:
							$class = 'warning';
							break;
						case User::STATUS_BLOCKED:
						default:
							$class = 'default';
					};
					
					$html = '<p class="text-right"><span class="label label-'.$class.'">'.Html::encode($model->getStatusName()).'</span>';
					return $value === null ? $column->grid->emptyCell : $html;
				}
			],
            [	
				'class' => 'yii\grid\ActionColumn', 
				'template' => '<p class="text-right">{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}</p>',
				/* 'buttons' => [
					'view' => function ($url, $model, $key) {
						$buttonOption = [
							'title' => 'Профиль',
							'aria-label' => 'Профиль',
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $key]), $buttonOption);
					}
				] */
			],
        ],
    ]); ?>
	<?= Html::endForm()?>
</div>
