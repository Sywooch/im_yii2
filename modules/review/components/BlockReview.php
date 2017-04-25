<?php
namespace app\modules\review\components;
use Yii;
use app\modules\review\models\Review;
class BlockReview
{
	public static function front($titleBlock = 'Отзывы', $num = 3)
	{
		$reviews = Review::find()->where(['status' => 1])->orderBy('weight')->limit($num)->all();
		//return $this->render('/review-block-front', ['titleBlock' => $titleBlock, 'reviews' => $reviews]);
		return Yii::$app->view->renderFile('@app/modules/review/views/review-block-front.php', ['titleBlock' => $titleBlock, 'reviews' => $reviews]);
	}
}