<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Общая информация сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siteinfo-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'meta_title',
            'meta_key:ntext',
            'meta_desc:ntext',
            'email:email',
            'phone',
            'address:ntext',
            'slogan',
            // 'body:ntext',
            // 'map:ntext',
            // 'counter:ntext',
            'copyright',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
