<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\file\components\Img;

use yii\helpers\ArrayHelper;

use app\modules\profile\Module;

$this->title = $model->lastname . ' ' . $model->name . ' ' . $model->phathername;
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portfolio-view">

    <!--<h3><?//= Html::encode($this->title) ?></h3>-->

    <!--<p>
        <?//= Html::a('Редактировать', ['/admin/profile/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?//= Html::a('Удалить', ['/admin/profile/delete', 'id' => $model->id], [
        //    'class' => 'btn btn-danger',
        //    'data' => [
        //        'confirm' => 'Вы уверены, что хотите удалить?',
        //        'method' => 'post',
        //    ],
        //]) ?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'label' => 'Ф.И.О.',
				'value' => $model->lastname.' '.$model->name.' '.$model->phathername,
				'format' => 'text',
			],
			'phone',
			'email',
			'sale',
			[
				'label' => 'Рассылка',
				'value' => ($model->sub)? '<p class="text-success">Подписан</p>':'<p class="text-danger">Неподписан</p>',
				'format' => 'html',
			],
            /* [
				'label' => 'Фото',
				'value' => ($model->files)? '<img src="'.Img::_('profile', $model->id, 'thumbnail', $model->files[0]->filename).'">':'',
				'format' => 'html',
			] */
        ],
    ]) ?>
</div>
