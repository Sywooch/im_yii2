<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирование (Аккаунт): ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Аккаунт', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h3><?= Html::encode($this->title) ?></h3>
	
	<?= Html::a('Изменить пароль', ['password-change', 'id' => $model->id], ['class' => 'btn btn-warning btn-xs']) ?>
	
	<hr>

    <?= $this->render('_form', [
        'model' => $model,
		'profileModel' => $profileModel,
    ]) ?>

</div>
