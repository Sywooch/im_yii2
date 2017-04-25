<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\file\components\Img;
use app\modules\catalog\Module;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-view">
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
            
			'short_title',
            'title',
			'parent_id',
			'alias',
            [
				'label' => 'Картинка',
				'value' => ($model->thumb)? '<img src="'.Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->thumb->filename).'">':'',
				'format' => 'html',
			],
            'teaser:html',
            'body:html',
            'weight',
            [
				'label' => 'Статус',
				'value' => ($model->status)? '<p class="text-success">Активный</p>':'<p class="text-danger">Неактивный</p>',
				'format' => 'html',
			],
        ],
    ]) ?>
</div>