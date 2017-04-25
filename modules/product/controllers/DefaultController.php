<?php
namespace app\modules\product\controllers;
use app\controllers\FrontendController;
use app\modules\product\models\Product;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use app\modules\product\Module;

use yii\data\ActiveDataProvider;

use Yii;
/**
 * Default controller for the `product` module
 */
class DefaultController extends FrontendController
{
	/**
     * Renders the view for the module
     * @return string
     */
    public function actionView($alias = '')
    {
		$this->view->params['page_class'] = '';
		
		$services = [];
		
		$product = Product::find()->where(['status' => 1, 'alias' => $alias])->one();
		
		if ($product) 
		{
			$search = '[ORDER_BUTTON]';
			$replace = '';
			
			if (!$product->is_not)
			{
				$replace = '<a class="button" onclick="addOrderProduct('.$product->id.', \''.htmlspecialchars($product->title).'\', \''.$product->price.'\');">Купить</a>';
			}
			
			$product->body = str_replace($search, $replace, $product->body);
			
			$this->view->title = $product->title;
			
			/******************** SEO ************************/
			if($product->seo) {
				if (!empty($product->seo->meta_title)) {
					$this->view->title = $product->seo->meta_title;
				}
				if (!empty($product->seo->meta_desc)) {
					$this->view->params['meta_description'] = $product->seo->meta_desc;
				}
				if (!empty($product->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $product->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
			
			return $this->render('/good', ['product' => $product]);
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
		$this->view->params['page_class'] = '';
		
		$this->processPageRequest('page');
		
		$query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => DEFAULT_FRONT_PAGE_SIZE
			],
        ]);
		
		$query->andFilterWhere(['is_main' => 0])
			->andFilterWhere(['status' => 1])
			->orderBy('weight');
			
		$product = $dataProvider->getModels();
		//$pagination = $dataProvider->getPagination();
		
		$mainProduct = Product::find()->where(['is_main' => 1])->one();
		
		if ($product) 
		{
            $this->view->title = 'Товары';
			$this->view->params['title_h1'] = 'Товары';
			
			/******************** SEO ************************/
			if($mainProduct && $mainProduct->seo) {
				if (!empty($mainProduct->seo->meta_title)) {
					$this->view->title = $mainProduct->seo->meta_title;
				}
				if (!empty($mainProduct->seo->title_h1)) {
					$this->view->params['title_h1'] = $mainProduct->seo->title_h1;
				}
				if (!empty($mainProduct->seo->meta_desc)) {
					$this->view->params['meta_description'] = $mainProduct->seo->meta_desc;
				}
				if (!empty($mainProduct->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $mainProduct->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
        }
		
		if (Yii::$app->request->isAjax)
		{
			return Yii::$app->view->renderFile('@app/modules/product/views/_loop.php', ['product' => $product]);
        } 
		else 
		{
			return $this->render('/product', ['dataProvider' => $dataProvider, 'product' => $product, 'mainProduct' => $mainProduct]);
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