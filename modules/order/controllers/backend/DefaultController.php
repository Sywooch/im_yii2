<?php

namespace app\modules\order\controllers\backend;

use Yii;

/********** USE MODELS *********/
use app\modules\order\models\Order;
use app\modules\order\models\OrderSearch;
use app\modules\order\models\OrderProduct;

use app\modules\shipping\models\Shipping;
use app\modules\payment\models\Payment;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

use app\modules\order\Module;

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * ClientController implements the CRUD actions for Order model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	/**
     * Creates a new OrderProduct model.
     * If creation is successful, the browser will be redirected to the 'view' client.
     * @return mixed
     */
    public function actionOrderProductCreateFast()
    {
        $model = new OrderProduct();
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['update', 'id' => $model->order_id]);
        }
        else
        {
            return $this->redirect(['index']);
        }
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' client.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
	
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
            return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/create', [
                'model' => $model,
				'shippingMethods' => $this->findShippingMethods(),
				'paymentMethods' => $this->findPaymentMethods(),
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' Order.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$newOrderProductModel = new OrderProduct();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
            $this->post = Yii::$app->request->post();

            return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
				'newOrderProductModel' => $newOrderProductModel,
				'orderProductModel' => $this->findOrderProductModel($id),
				'shippingMethods' => $this->findShippingMethods(),
				'paymentMethods' => $this->findPaymentMethods(),
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' Order.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		/*** Ищем связанные материалы и удаляем ***/
		OrderProduct::deleteAll(['order_id' => $id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
	
	/**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' Order.
     * @param string $id
     * @return mixed
     */
    public function actionOrderProductDelete($id)
    {
		$model = OrderProduct::findOne($id);
		$model->delete();
        return $this->redirect(['update', 'id' => $model->order_id]);
    }

    /**
     * MULTIDELETE Массовое удаление материалов
     * MULTIUPDATE Массовое редактирование материалов
     */
    public function actionMultiAction()
    {
        if($arrKey = Yii::$app->request->post('selection'))
        {
            if($arrKey AND is_array($arrKey) AND count($arrKey)>0)
            {
                foreach($arrKey as $id)
                {
                    /*** Ищем связанные материалы и удаляем ***/
                    OrderProduct::deleteAll(['order_id' => $id]);
                    $this->findModel($id)->delete();
                }
            }
        }

        if($multiedit = Yii::$app->request->post('multiedit'))
        {
            if($multiedit AND is_array($multiedit) AND count($multiedit)>0)
            {
                foreach($multiedit as $id => $field)
                {
                    if($model = $this->findModelForMultiAction($id))
                    {
                        foreach($field as $key => $value)
                        {
                            if(isset($field[$key]))
                            {
                                $model->{$key} = $value;
                            }
                        }
                        $model->save();
                    }
                }
            }
        }
        return $this->redirect(['index']);
    }
	
	/**
     * MULTIDELETE Массовое удаление районов
     * MULTIUPDATE Массовое редактирование районов
     */
    public function actionOrderProductMultiAction()
    {
        if($arrKey = Yii::$app->request->post('selection'))
        {
            if($arrKey AND is_array($arrKey) AND count($arrKey)>0)
            {
                foreach($arrKey as $id)
                {
                    OrderProduct::findOne($id)->delete();
                }
            }
        }

        if($multiedit = Yii::$app->request->post('multiedit'))
        {
            if($multiedit AND is_array($multiedit) AND count($multiedit)>0)
            {
                foreach($multiedit as $id => $field)
                {
                    if($model = OrderProduct::findOne($id))
                    {
                        foreach($field as $key => $value)
                        {
                            if(isset($field[$key]))
                            {
                                $model->{$key} = $value;
                            }
                        }
                        $model->save();
                    }
                }
            }
        }
        return $this->redirect(['update', 'id' => Yii::$app->request->post('order_id')]);
    }

    protected function findModelForMultiAction($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }
	
	/**
     * Fast Update in Popup window
     */
    public function actionCurrentOrderProducts()
    {
		$return = false;
		
		if($orderId = Yii::$app->request->post('orderId'))
		{
			$currentOrderProducts = OrderProduct::find()->where(['order_id' => $orderId])->all();
			
			if($currentOrderProducts)
			{
				$return = '';
				foreach($currentOrderProducts as $orderProduct)
				{
					$return .= Html::checkbox('Profile[orderProductsArray][]', false, ['label' => $orderProduct->title, 'value' => $orderProduct->id]);
				}
			}
		}
		return $return;      
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested client does not exist.');
        }
    }
	
	protected function findOrderProductModel($id)
    {
        $query = OrderProduct::find()->where(['order_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $dataProvider;
    }
	
	protected function findShippingMethods()
	{
		return Shipping::find()->where(['status' => 1])->orderBy('weight')->all();
	}
	
	protected function findPaymentMethods()
	{
		return Payment::find()->where(['status' => 1])->orderBy('weight')->all();
	}
}
