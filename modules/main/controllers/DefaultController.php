<?php

namespace app\modules\main\controllers;

use Yii;
use app\controllers\FrontendController;
use app\modules\main\models\forms\FormContact;
use app\modules\main\models\forms\FormRecall;
use app\modules\main\models\forms\FormAction;
use app\modules\main\models\forms\FormProduct;

use app\modules\action\models\Action;
use app\modules\article\models\Article;
use app\modules\product\models\Product;
use app\modules\service\models\Service;
use app\modules\page\models\Page;
use app\modules\order\models\Order;
use app\modules\order\models\OrderProduct;
use app\modules\user\models\User;

use yii2tech\sitemap\File;

/**
 * Default controller for the `main` module
 */
class DefaultController extends FrontendController
{
	private $items = [];
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('/index');
    }
	
	public function catalogListItems($dataProvider, $url = '', $parentId = 0, $level = 0, $foolproof = 20)
    {
		if ($dataProvider) 
		{
			foreach ($dataProvider as $element) 
			{
				if ($parentId == 0) 
				{
					if(!$element->parent)
					{
						$this->items[] = [
							'link' => '/'.$url.'/'.$element->alias,
							'priority' => '0.8',
							'changeFrequency' => 'weekly',
						];
						$parentUrl = $url.'/'.$element->alias;
						$this->catalogListItems($dataProvider, $parentUrl, $element->id, $level+1, $foolproof-1);
					}
				} 
				else 
				{
					if($element->parent)
					{
						foreach($element->parent as $item)
						{
							if ($item->id == $parentId) 
							{
								$this->items[] = [
									'link' => '/'.$url.'/'.$element->alias,
									'priority' => '0.8',
									'changeFrequency' => 'weekly',
								];
								$parentUrl = $url.'/'.$element->alias;
								$this->catalogListItems($dataProvider, $parentUrl, $element->id, $level+1, $foolproof-1);
							}
						}
					}
				}
			}
		}
    }
	
	public function actionSitemap()
	{
		/* if (!$xml = Yii::$app->cache->get('sitemap'))
        { */
			$services = Service::find()->where(['status' => 1, 'is_main' => 0])->all();
			$articles = Article::find()->where(['status' => 1, 'is_main' => 0])->all();
			$actions = Action::find()->where(['status' => 1, 'is_main' => 0])->all();
			$products = Product::find()->where(['status' => 1, 'is_main' => 0])->all();
			$pages = Page::find()->where(['status' => 1])->all();
			
			// Main
			$this->items[] = [
				'link' => '/',
				'priority' => '0.9',
				'changeFrequency' => 'weekly',
			];
			
			// Services
			if($services)
			{
				$this->items[] = [
					'link' => '/services',
					'priority' => '0.8',
					'changeFrequency' => 'weekly',
				];
				$this->catalogListItems($services, $url = 'services');
			}
			
			// Articles
			if($articles)
			{
				$this->items[] = [
					'link' => '/articles',
					'priority' => '0.8',
					'changeFrequency' => 'weekly',
				];
				foreach($articles as $item)
				{
					$this->items[] = [
						'link' => '/articles/'.$item->alias,
						'priority' => '0.8',
						'changeFrequency' => 'weekly',
					];
				}
			}
			
			// Actions
			if($actions)
			{
				$this->items[] = [
					'link' => '/actions',
					'priority' => '0.8',
					'changeFrequency' => 'weekly',
				];
				foreach($actions as $item)
				{
					$this->items[] = [
						'link' => '/actions/'.$item->alias,
						'priority' => '0.8',
						'changeFrequency' => 'weekly',
					];
				}
			}
			
			// Products
			if($products)
			{
				$this->items[] = [
					'link' => '/products',
					'priority' => '0.8',
					'changeFrequency' => 'weekly',
				];
				foreach($products as $item)
				{
					$this->items[] = [
						'link' => '/products/'.$item->alias,
						'priority' => '0.8',
						'changeFrequency' => 'weekly',
					];
				}
			}
			
			// Pages
			if($pages)
			{
				foreach($pages as $item)
				{
					$this->items[] = [
						'link' => '/'.$item->alias,
						'priority' => '0.8',
						'changeFrequency' => 'weekly',
					];
				}
			}
			$xml = $this->renderPartial('/sitemap', ['items' => $this->items]);
            /* Yii::$app->cache->set('sitemap', $xml, 3600*6);
		} */
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_XML; // устанавливаем формат отдачи контента
		echo $xml;
	}
	
	/***************************** Переадресация внешних ссылок **********************************/
	public function actionGo()
    {
		if($ref = Yii::$app->request->get('ref'))
		{
			return $this->redirect('http://'.$ref, 301)->send();
		}
    }
	
	/***************************** Отправка формы "Обратная связь" по AJAX **********************************/
	public function actionSendContactForm()
    {
		$form = new FormContact();
        if ($form->load(Yii::$app->request->post()) AND $form->contact($this->siteinfo->email)) 
		{
            echo 'success';
        } else {
			echo 'error';
		}
    }
	
	/***************************** Отправка формы "Обратный звонок" по AJAX **********************************/
	public function actionSendRecallForm()
    {
		$form = new FormRecall();
        if ($form->load(Yii::$app->request->post()) AND $form->send($this->siteinfo->email))
		{
            echo 'success';
        } else {
			echo 'error';
		}
    }
	
	/***************************** Отправка формы "Записаться на акции" по AJAX **********************************/
	public function actionSendActionForm()
    {
		$form = new FormAction();
        if ($form->load(Yii::$app->request->post()))
		{
            $post = Yii::$app->request->post('FormAction');
			
			$productModel = Action::findOne($post['product_id']);
		
			if ($form->send($this->siteinfo->email, $productModel))
			{
				echo 'success';
			} 
			else 
			{
				echo 'error';
			}
			
        } else {
			echo 'error';
		}
    }
	
	/***************************** Отправка формы "Заказ товара" по AJAX **********************************/
	public function actionSendProductForm()
    {
		$form = new FormProduct();
		
		if ($form->load(Yii::$app->request->post()))
		{
			$post = Yii::$app->request->post('FormProduct');
			
			$productModel = Product::findOne($post['product_id']);
			
			if($productModel)
			{
				$orderModel = new Order();
				
				if (Yii::$app->user->isGuest) 
				{
					$orderModel->user_id = 0;
				}
				else
				{
					$orderModel->user_id = Yii::$app->user->identity->id;
				}
				
				$orderModel->email = $post['email'];
				
				$orderModel->date = date('Y-m-d');
				$orderModel->status = 0;
				$orderModel->name = $post['name'];
				$orderModel->phone = $post['phone'];
				$orderModel->address = '';
				$orderModel->city = '';
				$orderModel->shipping = 0;
				$orderModel->payment = 0;
				$orderModel->type = 'product';
				$orderModel->total = $productModel->price;
				$orderModel->text = $post['text'];
				
				if($orderModel->save())
				{
					$orderProductModel = new OrderProduct();
					$orderProductModel->order_id = $orderModel->id;
					$orderProductModel->product_id = $productModel->id;
					$orderProductModel->product_title = $productModel->title;
					$orderProductModel->product_code = '';
					$orderProductModel->product_option = '';
					$orderProductModel->product_price = $productModel->price;
					$orderProductModel->product_qty = 1;
					$orderProductModel->product_total = $productModel->price * 1;
					$orderProductModel->save();
				}
			}
		
			if ($form->send($this->siteinfo->email, $productModel))
			{
				echo 'success';
			} 
			else 
			{
				echo 'error';
			}
		}
		else
		{
			echo 'error';
		}
    }
}