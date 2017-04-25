<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\DetailView;
use app\modules\file\components\Img;
use app\modules\product\Module;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
			'alias',
			
            [
				'label' => 'Картинка',
				'value' => ($model->thumb)? '<img src="'.Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename).'">':'',
				'format' => 'html',
			],
			
			'price',
			'old_price',
            'teaser:html',
            'body:html',
            'weight',
			[
				'label' => 'Наличие',
				'value' => ($model->is_not)? '<p class="text-success">Нет в наличии</p>':'<p class="text-danger">В наличии</p>',
				'format' => 'html',
			],
            [
				'label' => 'Статус',
				'value' => ($model->status)? '<p class="text-success">Активный</p>':'<p class="text-danger">Неактивный</p>',
				'format' => 'html',
			],
        ],
    ]) ?>

</div>
