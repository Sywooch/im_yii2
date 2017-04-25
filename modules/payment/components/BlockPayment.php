<?php

namespace app\modules\payment\components;

use Yii;
use app\modules\payment\models\Payment;

class BlockPayment
{
	public static function front($titleBlock = 'Способы оплаты')
	{
		$payment = Payment::find()->where(['status' => 1])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/payment/views/payment-block-front.php', ['titleBlock' => $titleBlock, 'payment' => $payment]);
	}
}