<?php

namespace app\modules\payment\controllers\backend;

use Yii;

/********** USE MODELS *********/
use app\modules\payment\models\Payment;
use yii\data\ActiveDataProvider;
use app\modules\file\models\File;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\payment\Module;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Payment::find()->orderBy('weight');
		$data = new ActiveDataProvider([
			'query' => $query,
		]);
        return $this->render('/backend/index', [
            'data' => $data,
        ]);
    }
	
    /**
     * Displays a single Payment model.
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
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' payment.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();
		
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/create', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' payment.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' payment.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		/*** Удаляем сам материал ***/
		$model->delete();
		
		/*** Удаляем файлы и записи из таблицы file ***/
		$fileModel = new File();
        $fileModel->deleteFiles($id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
		
        return $this->redirect(['index']);
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
					$model = $this->findModel($id);
					/*** Удаляем сам материал ***/
					$model->delete();
					
					$fileModel = new File();
					/*** Удаляем файлы и записи из таблицы file ***/
					$fileModel->deleteFiles($id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
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
	
	protected function findModelForMultiAction($id)
	{
		if (($model = Payment::findOne($id)) !== null) {
			return $model;
		} else {
			return false;
		}
	}
	
    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested payment does not exist.');
        }
    }
}