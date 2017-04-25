<?php
namespace app\components\widgets;

use Yii;

class Related
{
	public static function _($model = false, $titleBlock = 'Это может быть интересно')
	{
		$data = [];
		$is_content = false;
		
		if(isset($model->attach_title) && !empty($model->attach_title))
		{
			$titleBlock = $model->attach_title;
		}
			
		// attachProducts
		if($model && isset($model->attachProducts) && $model->attachProducts)
		{
			$attProduct = $model->getAttachProducts()->orderBy('weight')->all();
			foreach($attProduct as $value)
			{
				if(!$is_content && $value) $is_content = true;
				$data[] = [
					'content' => $value,
					'linkModule' => 'products',
					'type' => 'product',
				];
			}
		}
		return Yii::$app->view->renderFile('@app/views/frontend/block-related.php', ['data' => $data, 'is_content' => $is_content, 'titleBlock' => $titleBlock]);
	}
}