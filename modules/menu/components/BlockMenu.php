<?php

namespace app\modules\menu\components;
use Yii;
use app\modules\menu\models\Menu;

class BlockMenu
{
	public static function main($stylePrefix = '', $type = 0)
	{
		$menu = Menu::find()->where(['status' => 1, 'parent_id' => 0, 'type_id' => $type])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/menu/views/main-menu.php', ['menu' => $menu, 'stylePrefix' => $stylePrefix]);
	}
	
	public static function social($type = 1)
	{
		$menu = Menu::find()->where(['status' => 1, 'parent_id' => 0, 'type_id' => $type])->orderBy('weight')->all();
		return Yii::$app->view->renderFile('@app/modules/menu/views/social-menu.php', ['menu' => $menu]);
	}
}