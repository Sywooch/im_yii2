<?php
namespace app\modules\catalog\components;
use Yii;
use app\modules\catalog\models\Catalog;

class BlockCatalog
{
	public static function front($currentUrl = '')
	{
		$catalog = Catalog::find()->where(['is_main' => 0, 'in_front' => 1, 'status' => 1])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/catalog/views/catalog-block-front.php', ['catalog' => $catalog, 'currentUrl' => $currentUrl]);
	}
	
	public static function left($currentUrl = '')
	{
		$catalog = Catalog::find()->where(['is_main' => 0, 'status' => 1])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/catalog/views/catalog-block-left.php', ['catalog' => $catalog, 'currentUrl' => $currentUrl]);
	}
}