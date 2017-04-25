<?php
namespace app\modules\option\components;

use Yii;
use app\modules\option\models\Option;

class BlockOption
{
	public static function front($content_id = 0, $module = 'product', $type = 1, $titleBlock = 'Опции')
	{
		$options = Option::find()->where(['content_id' => $content_id, 'module' => $module, 'option_type' => $type])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/option/views/option-block-front.php', ['titleBlock' => $titleBlock, 'options' => $options]);
	}
}