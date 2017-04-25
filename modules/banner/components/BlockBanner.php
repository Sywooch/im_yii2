<?php

namespace app\modules\banner\components;
use Yii;
use app\modules\banner\models\Banner;

class BlockBanner
{
	public static function _($num = 100)
	{
		$content = Banner::find()->where(['status' => 1])->orderBy('weight')->limit($num)->all();
		return Yii::$app->view->renderFile('@app/modules/banner/views/banner-block.php', ['content' => $content]);
	}
}