<?php
namespace app\modules\feature\components;

use Yii;
use app\modules\feature\models\Feature;

class BlockFeature
{
	public static function front($content_id = 0, $module = 'product', $titleBlock = 'Характеристики')
	{
		$features = Feature::find()->where(['content_id' => $content_id, 'module' => $module])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/feature/views/feature-block-front.php', ['titleBlock' => $titleBlock, 'features' => $features]);
	}
}