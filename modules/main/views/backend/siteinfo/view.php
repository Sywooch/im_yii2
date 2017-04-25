<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\file\components\Img;
use app\modules\main\Module;

/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Инфо', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siteinfo-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Настройка дополнительных параметров', ['setting', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'label' => 'Логотип',
                'value' => ($model->logo)? '<img src="'.Img::_(Module::getInstance()->imagesDirectory, $model->id, 'thumbnail', $model->logo->filename).'">':'',
                'format' => 'html',
            ],
            [
                'label' => 'Иконка',
                'value' => ($model->icon)? '<img src="/'.$model->icon->filename.'">':'',
                'format' => 'html',
            ],
            'email:email',
            'phone:html',
            'address:html',
            'slogan',
            'body:html',
            /* 'map:html',
            'counter:ntext', */
            'copyright',
        ],
    ]) ?>

</div>
