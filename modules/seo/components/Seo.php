<?php
namespace app\modules\seo\components;
use Yii;
class Seo
{
	public static function _fieldsView($model = NULL, $blockTitle = '', $is_main_event = false)
	{
		$data = [
			'title_h1' => '',
			'meta_title' => '',
			'meta_key' => '',
			'meta_desc' => '',
			'title_h12' => '',
			'meta_title2' => '',
			'meta_key2' => '',
			'meta_desc2' => '',
		];
		if($model->seo)
		{
			if($is_main_event)
			{
				$data = [
					'title_h1' => $model->seo->title_h1,
					'meta_title' => $model->seo->meta_title,
					'meta_key' => $model->seo->meta_key,
					'meta_desc' => $model->seo->meta_desc,
					'title_h12' => $model->seo->title_h12,
					'meta_title2' => $model->seo->meta_title2,
					'meta_key2' => $model->seo->meta_key2,
					'meta_desc2' => $model->seo->meta_desc2,
				];
			}
			else
			{
				$data = [
					'title_h1' => $model->seo->title_h1,
					'meta_title' => $model->seo->meta_title,
					'meta_key' => $model->seo->meta_key,
					'meta_desc' => $model->seo->meta_desc,
				];
			}
		}
		return Yii::$app->view->renderFile('@app/modules/seo/views/backend/fields-block.php',
											[
												'data' => $data,
												'blockTitle' => $blockTitle,
												'is_main_event' => $is_main_event,
											]
										);
	}
}