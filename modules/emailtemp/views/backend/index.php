<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\grid\GridView;

use yii\widgets\ActiveForm;
use app\modules\emailtemp\models\Emailtemp;
use app\modules\emailtemp\Module;

$this->title = 'Шаблоны писем';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailtemp-index">

    <h3><?= Html::encode($this->title) ?></h3>

	<hr>

	<p>
		<?= Html::a('Создать новый шаблон', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
	</p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'title',
			'subject',
			[
				'filter' => Emailtemp::getActArray(),
				'attribute' => 'act',
				'format' => 'raw',
				'value' => function ($model, $key, $index, $column) {
					$value = $model->{$column->attribute};
					
					$html = Html::encode($model->getActName());
					return $value === null ? $column->grid->emptyCell : $html;
				}
			],
            [	
				'class' => 'yii\grid\ActionColumn', 
				'template' => '<p class="text-right">{update}&nbsp;&nbsp;{delete}</p>'
			],
        ],
    ]); ?>
	<?= Html::endForm()?>
</div>
