<?php
namespace app\modules\emailtemp\components;

use Yii;
use app\modules\emailtemp\models\Emailtemp;

class BlockEmailtemp
{
	public static function _($blockId = 0)
	{
		return Emailtemp::find()->where(['act' => $blockId])->one();
	}
}