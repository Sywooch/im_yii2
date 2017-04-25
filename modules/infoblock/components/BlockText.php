<?php
namespace app\modules\infoblock\components;

use Yii;
use app\modules\infoblock\models\Infoblock;

class BlockText
{
	public static function _($blockId = '', $titleBlock = '')
	{
		$infoblock = Infoblock::find()->where(['status' => 1, 'alias' => $blockId])->orderBy('weight')->one();
		
		if($infoblock)
		{
			return Yii::$app->view->renderFile('@app/modules/infoblock/views/page-block.php', ['titleBlock' => $titleBlock, 'block' => $infoblock]);
		}
	}
}