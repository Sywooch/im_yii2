<?php

namespace app\modules\search\controllers;

use app\controllers\FrontendController;

use app\modules\catalog\models\Catalog;
use app\modules\article\models\Article;
use app\modules\action\models\Action;
use app\modules\page\models\Page;
use app\modules\product\models\Product;

use yii\data\ActiveDataProvider;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use Yii;

/**
 * Default controller for the `search` module
 */
class DefaultController extends FrontendController
{
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		$search = [];
		
		$q = Yii::$app->request->get('q');
		
		if($q)
		{
			/** Catalog **/
			$catalogQuery = Catalog::find()
					->with('thumb')
					->where(['status' => 1]);
			
			$catalogDataProvider = new ActiveDataProvider([
				'query' => $catalogQuery,
				'pagination' => [
					'pageSize' => 1000
				],
			]);
			
			/** Article **/		
			$articleQuery = Article::find()
					->with('thumb')
					->where(['status' => 1]);
					
			$articleDataProvider = new ActiveDataProvider([
				'query' => $articleQuery,
				'pagination' => [
					'pageSize' => 1000
				],
			]);
			
			/** Action **/		
			$actionQuery = Action::find()
					->with('thumb')
					->where(['status' => 1]);
					
			$actionDataProvider = new ActiveDataProvider([
				'query' => $actionQuery,
				'pagination' => [
					'pageSize' => 1000
				],
			]);
			
			/** Page **/		
			$pageQuery = Page::find()
					->where(['status' => 1]);
					
			$pageDataProvider = new ActiveDataProvider([
				'query' => $pageQuery,
				'pagination' => [
					'pageSize' => 1000
				],
			]);
			
			/** Product **/		
			$productQuery = Product::find()
					->with('thumb')
					->where(['status' => 1]);
			
			$productDataProvider = new ActiveDataProvider([
				'query' => $productQuery,
				'pagination' => [
					'pageSize' => 1000
				],
			]);
			
			/********************** QUERIES ***********************/
		
			$catalogQuery->andFilterWhere(['like', 'title', $q]);
			$catalogQuery->orFilterWhere(['like', 'body', $q]);
			
			$articleQuery->andFilterWhere(['like', 'title', $q]);
			$articleQuery->orFilterWhere(['like', 'body', $q]);
			
			$actionQuery->andFilterWhere(['like', 'title', $q]);
			$actionQuery->orFilterWhere(['like', 'body', $q]);
			
			$pageQuery->andFilterWhere(['like', 'title', $q]);
			$pageQuery->orFilterWhere(['like', 'body', $q]);
			
			$productQuery->andFilterWhere(['like', 'title', $q]);
			$productQuery->orFilterWhere(['like', 'body', $q]);
		
			/*********************** GET MODELES *******************/
			$catalogSearch = $catalogDataProvider->getModels();
			if($catalogSearch)
			{
				$search['Каталог'] = [
					'module' => 'catalog',
					'link' => '/cat/',
					'is_id' => 0,
					'is_date' => 0,
					'content' => $catalogSearch,
				];
			}
			
			$articleSearch = $articleDataProvider->getModels();
			if($articleSearch)
			{
				$search['Горячие темы'] = [
					'module' => 'article',
					'link' => '/articles/',
					'is_id' => 0,
					'is_date' => 1,
					'content' => $articleSearch,
				];
			}
			
			$actionSearch = $actionDataProvider->getModels();
			if($actionSearch)
			{
				$search['Акции'] = [
					'module' => 'action',
					'link' => '/actions/',
					'is_id' => 0,
					'is_date' => 0,
					'content' => $actionSearch,
				];
			}
			
			$pageSearch = $pageDataProvider->getModels();
			if($pageSearch)
			{
				$search['Страницы'] = [
					'module' => 'page',
					'link' => '/',
					'is_id' => 0,
					'is_date' => 0,
					'content' => $pageSearch,
				];
			}
			
			$productSearch = $productDataProvider->getModels();
			if($productSearch)
			{
				$search['Товары'] = [
					'module' => 'product',
					'link' => '/products/',
					'is_id' => 0,
					'is_date' => 0,
					'content' => $productSearch,
				];
			}
		}
		
		//$pagination = $dataProvider->getPagination();
		
        $this->view->title = 'Результаты поиска';
		return $this->render('/search', [
			'search' => $search,
		]);
    }
}