<?php
namespace app\modules\action\components;

use Yii;
use app\modules\action\models\Action;

class BlockAction
{
	public static function front($titleBlock = 'Акции', $num = 3)
	{
		$actions = Action::find()->where(['status' => 1])->orderBy('weight')->limit($num)->all();
		//return $this->render('/action-block', ['titleBlock' => $titleBlock, 'actions' => $actions]);
		return Yii::$app->view->renderFile('@app/modules/action/views/action-block-front.php', ['titleBlock' => $titleBlock, 'actions' => $actions]);
	}
}