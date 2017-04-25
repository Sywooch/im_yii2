<?php
namespace app\modules\address\components;

use Yii;
use app\modules\address\models\Address;

class BlockAddress
{
	public static function front($titleBlock = 'Ваши адреса')
	{
		$addresses = Address::find()->where(['account_type' => 0])->all();
		return Yii::$app->view->renderFile('@app/modules/address/views/address-block-front.php', ['titleBlock' => $titleBlock, 'addresses' => $addresses]);
	}
}