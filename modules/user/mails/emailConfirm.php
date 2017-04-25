<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>
<?= Yii::t('app', 'HELLO {username}', ['username' => $user->username]); ?><br>
<?= Yii::t('app', 'FOLLOW_TO_CONFIRM_EMAIL') ?><br>
<?= Html::a(Html::encode($confirmLink), $confirmLink) ?><br>
<?= Yii::t('app', 'IGNORE_IF_DO_NOT_REGISTER') ?>