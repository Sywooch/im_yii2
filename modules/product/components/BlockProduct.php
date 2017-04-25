<?php
namespace app\modules\product\components;

use Yii;
use app\modules\product\models\Product;

class BlockProduct
{
	/* public static function service($titleBlock = 'Наши работы', $service = 0, $mode = 0)
	{
		if($mode)
		{
			$se = $service['products'];
		}
		else
		{
			$se = $service->getProducts()->orderBy(['project_start' => SORT_DESC])->all();
		}
		return Yii::$app->view->renderFile('@app/modules/product/views/product-block-front.php', ['titleBlock' => $titleBlock, 'product' => $se]);
	}
	
	public static function client($titleBlock = 'Отзывы и работы', $client = 0)
	{
		return Yii::$app->view->renderFile('@app/modules/product/views/product-block-client.php', ['titleBlock' => $titleBlock, 'product' => $client->getProducts()->orderBy(['project_start' => SORT_DESC])->all(), 'reviews' => $client->reviews]);
	}
	
	public static function review($titleBlock = 'Работы', $review = 0)
	{
		if($review->client)
		{
			return Yii::$app->view->renderFile('@app/modules/product/views/product-block-front.php', ['titleBlock' => $titleBlock, 'product' => $review->client->products]);
		}
	} */
}