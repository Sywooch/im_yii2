<?php

namespace app\modules\article\controllers;

use app\controllers\FrontendController;
use app\modules\article\models\Article;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

use yii\data\ActiveDataProvider;

use Yii;

/**
 * Default controller for the `article` module
 */
class DefaultController extends FrontendController
{
	/**
     * Renders the view for the module
     * @return string
     */
    public function actionView($alias = '')
    {
		$article = Article::find()->where(['status' => 1, 'alias' => $alias])->one();
		
		if ($article) 
		{
            $this->view->title = $article->title;
			
			/******************** SEO ************************/
			if($article->seo) {
				if (!empty($article->seo->meta_title)) {
					$this->view->title = $article->seo->meta_title;
				}

				if (!empty($article->seo->meta_desc)) {
					$this->view->params['meta_description'] = $article->seo->meta_desc;
				}

				if (!empty($article->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $article->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
			
			return $this->render('/article', ['article' => $article]);
			
        } 
		else 
		{
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
	
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		$this->processPageRequest('page');
		
		$query = Article::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => DEFAULT_FRONT_PAGE_SIZE
			],
        ]);
		
		$query->andFilterWhere(['is_main' => 0])
			->andFilterWhere(['status' => 1])
			->orderBy(['date' => SORT_DESC]);
			
			
		$articles = $dataProvider->getModels();
		//$pagination = $dataProvider->getPagination();
		
		$mainArticle = Article::find()->where(['is_main' => 1])->one();
		
		if ($articles) {
		
            $this->view->title = 'Горячие темы';
			$this->view->params['title_h1'] = 'Горячие темы';
			
			/******************** SEO ************************/
			if($mainArticle && $mainArticle->seo) {
				if (!empty($mainArticle->seo->meta_title)) {
					$this->view->title = $mainArticle->seo->meta_title;
				}
				if (!empty($mainArticle->seo->title_h1)) {
					$this->view->params['title_h1'] = $mainArticle->seo->title_h1;
				}
				if (!empty($mainArticle->seo->meta_desc)) {
					$this->view->params['meta_description'] = $mainArticle->seo->meta_desc;
				}
				if (!empty($mainArticle->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $mainArticle->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
        }
		
		if (Yii::$app->request->isAjax)
		{
			return Yii::$app->view->renderFile('@app/modules/article/views/_loop.php', ['articles' => $articles]);
        } 
		else 
		{
			return $this->render('/articles', ['dataProvider' => $dataProvider, 'articles' => $articles, 'mainArticle' => $mainArticle]);
        }
    }
	
	protected function processPageRequest($param = 'page')
    {
        if (Yii::$app->request->isAjax && isset($_POST[$param]))
		{
			$_GET[$param] = Yii::$app->request->post($param);
		}
    }
}