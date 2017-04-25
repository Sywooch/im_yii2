<?php
namespace app\modules\article\components;

use Yii;
use app\modules\article\models\Article;

class BlockArticle
{
	public static function front($titleBlock = 'Статьи', $num = 3)
	{
		$articles = Article::find()->where(['status' => 1])->orderBy('weight')->limit($num)->all();
		//return $this->render('/article-block', ['titleBlock' => $titleBlock, 'articles' => $articles]);
		return Yii::$app->view->renderFile('@app/modules/article/views/article-block-front.php', ['titleBlock' => $titleBlock, 'articles' => $articles]);
	}
}