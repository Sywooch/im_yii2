<?php
namespace app\modules\order\controllers;

use app\controllers\FrontendController;

use app\modules\profile\models\Profile;
use app\modules\order\models\Order;
use app\modules\order\models\OrderProduct;
use app\modules\order\models\forms\FormOrder;

use app\modules\shipping\models\Shipping;
use app\modules\payment\models\Payment;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use app\modules\order\Module;

use Yii;
/**
 * Default controller for the `product` module
 */
class DefaultController extends FrontendController
{
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		$this->view->params['page_class'] = '';
		$this->view->title = 'Корзина';
		$this->view->params['title_h1'] = 'Ваши товары';
		
		$cart = yii::$app->cart;
		
		$model = new FormOrder();
		
		$shippingMethods = Shipping::find()->where(['status' => 1])->orderBy('weight')->all();
		$paymentMethods = Payment::find()->where(['status' => 1])->orderBy('weight')->all();
		
		if (!Yii::$app->user->isGuest) 
		{
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
				$model->name = $profileModel->name;
				$model->phone = $profileModel->phone;
				$model->email = Yii::$app->user->identity->email;
			}
		}
		
		if ($model->load(Yii::$app->request->post()))
		{
			$post = Yii::$app->request->post('FormOrder');
			
			if($cart->elements && count($cart->elements)>0)
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
				$orderModel->shipping = $post['shipping'];
				$orderModel->payment = $post['payment'];
				$orderModel->type = 'product';
				$orderModel->total = $cart->cost;
				$orderModel->text = $post['text'];
				
				if($orderModel->save())
				{
					foreach($cart->elements as $item)
					{
						$orderProductModel = new OrderProduct();
						
						$options = $item->getModel()->getCartOptions();
						
						if($options)
						{
							if(is_array($options)) {
								$orderProductModel->product_option = json_encode($options);
							} else {
								$orderProductModel->product_option = $options;
							}
						}

						$orderProductModel->order_id = $orderModel->id;
						$orderProductModel->product_id = $item->getModel()->getCartId();
						$orderProductModel->product_title = $item->getModel()->getCartName();
						$orderProductModel->product_code = $item->getModel()->getCartCode();
						$orderProductModel->product_price = $item->getModel()->getCartPrice();
						$orderProductModel->product_qty = $item->count;
						$orderProductModel->product_total = $item->getModel()->getCartPrice() * $item->count;
						$orderProductModel->save();
					}
					$cart->truncate(); // Очищаем корзину
				}
			}
		
			if ($model->send($this->siteinfo->email))
			{
				Yii::$app->getSession()->setFlash('success', 'Ваш заказ успешно оформлен!');
				//return $this->redirect(['/']);
			} 
			else 
			{
				$errors = $model->errors;
				Yii::$app->getSession()->setFlash('error', print_r($errors));
				//return $this->redirect(['/']);
			}
		}
		
		return $this->render('/cart', [
			'elements' => $cart->elements, 
			'model' => $model, 
			'shippingMethods' => $shippingMethods, 
			'paymentMethods' => $paymentMethods
		]);
    }
}