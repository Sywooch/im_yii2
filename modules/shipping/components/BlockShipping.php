<?php

namespace app\modules\shipping\components;

use Yii;
use app\modules\shipping\models\Shipping;

class BlockShipping
{
	public static function front($titleBlock = 'Способы доставки')
	{
		$shipping = Shipping::find()->where(['status' => 1])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/shipping/views/shipping-block-front.php', ['titleBlock' => $titleBlock, 'shipping' => $shipping]);
	}
}