<?php
namespace app\modules\user\components;
use Yii;
use app\modules\user\models\forms\FormLogin;
class BlockLogin
{
	public static function _()
	{
		$model = new FormLogin();
		return Yii::$app->view->renderFile('@app/modules/user/views/popup/login-block.php', ['model' => $model]);
	}
}