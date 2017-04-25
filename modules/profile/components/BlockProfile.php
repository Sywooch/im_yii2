<?php
namespace app\modules\profile\components;

use Yii;
use app\modules\profile\models\Profile;

class BlockProfile
{
	public static function front($titleBlock = 'Наши передовики')
	{
		$profiles = Profile::find()->where(['account_type' => 0])->all();
		return Yii::$app->view->renderFile('@app/modules/profile/views/profile-block-front.php', ['titleBlock' => $titleBlock, 'profiles' => $profiles]);
	}
}