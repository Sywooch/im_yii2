<?php

namespace app\modules\product\controllers\backend;

use Yii;

/********** USE MODELS *********/
use app\modules\action\models\Action;
use app\modules\catalog\models\Catalog;
use app\modules\product\models\Product;
use app\modules\product\models\ProductSearch;

use app\modules\feature\models\Feature;
use app\modules\option\models\Option;

use app\modules\file\models\File;
use app\modules\seo\models\Seo;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\product\Module;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
		$mainModel = Product::find()->where(['is_main' => 1])->one();
		
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'mainModel' => $mainModel,
        ]);
    }
	
    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' product.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
		
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			/*** Редактирование (добавление) файлов для галереи ***/
			$fileModel->updateFiles($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			/*** Редактирование SEO ***/
			$seoModel = new Seo();
			$seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/create', [
                'model' => $model,
				'productItems' => $this->findAllProductItems(),
				'actionItems' => $this->findAllActionItems(),
				'catalogItems' => $this->findAllCatalogItems(),
				'features' => $this->findFeatures(0),
				'options' => $this->findOptions(0),
            ]);
        }
    }
	
	public function actionCreateMain()
    {
        $model = new Product();
		
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию
		$model->is_main = 1; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование SEO ***/
			$seoModel = new Seo();
			$seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/create-main', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateMain($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование SEO ***/
			$seoModel = new Seo();
			$seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/update-main', [
                'model' => $model,
            ]);
        }
    }
	
	/**
	 * Fast Update in Popup window
	 */
	public function actionUpdateFast($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			$this->post = Yii::$app->request->post();
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			return $this->redirect([$this->post['popup_edit_redirect']]); // Возвращаемся на предыдущую страницу
		}
		else
		{
			return $this->renderAjax('/backend/update-fast', [
				'model' => $model,
				'productItems' => $this->findAllProductItems(),
				'actionItems' => $this->findAllActionItems(),
				'catalogItems' => $this->findAllCatalogItems(),
				'features' => $this->findFeatures($id),
				'options' => $this->findOptions($id),
			]);
		}
	}
	
    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' product.
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
			/*** Редактирование (добавление) файлов для галереи ***/
			$fileModel->updateFiles($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			/*** Редактирование SEO ***/
			$seoModel = new Seo();
			$seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);
			return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
				'productItems' => $this->findAllProductItems(),
				'actionItems' => $this->findAllActionItems(),
				'catalogItems' => $this->findAllCatalogItems(),
				'features' => $this->findFeatures($id),
				'options' => $this->findOptions($id),
            ]);
        }
    }
	
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' product.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		/*** Удаляем записи из связанной таблицы product_action ***/
		if($model->actions)
		{
			foreach($model->actions as $obj)
			{
				$model->unlink('actions', $obj, true);
			}
		}
		
		/*** Удаляем записи из связанной таблицы product_catalog ***/
		if($model->catalog)
		{
			foreach($model->catalog as $obj)
			{
				$model->unlink('catalog', $obj, true);
			}
		}
		
		/*** Удаляем записи из связанной таблицы product_product ***/
		if($model->products)
		{
			foreach($model->products as $obj)
			{
				$model->unlink('products', $obj, true);
			}
		}
		
		/*** Удаляем сам материал ***/
		$model->delete();
		
		/*** Удаляем связанные характеристики ***/
		Feature::deleteAll(['module' => Module::getInstance()->id, 'content_id' => $id]);
		
		/*** Удаляем связанные опции ***/
		Option::deleteAll(['module' => Module::getInstance()->id, 'content_id' => $id]);
		
		/*** Удаляем файлы и записи из таблицы file ***/
		$fileModel = new File();
        $fileModel->deleteFiles($id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
		
		/*** Удаляем записи из таблицы seo ***/
		$seoModel = new Seo();
        $seoModel->deleteSeo($id, Module::getInstance()->id);
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
				$seoModel = new Seo();
				$fileModel = new File();
				foreach($arrKey as $id)
				{
					$model = $this->findModel($id);
					
					/*** Удаляем записи из связанной таблицы product_action ***/
					if($model->actions)
					{
						foreach($model->actions as $obj)
						{
							$model->unlink('actions', $obj, true);
						}
					}
					
					/*** Удаляем записи из связанной таблицы product_catalog ***/
					if($model->catalogs)
					{
						foreach($model->catalog as $obj)
						{
							$model->unlink('catalog', $obj, true);
						}
					}
					
					/*** Удаляем записи из связанной таблицы product_product ***/
					if($model->products)
					{
						foreach($model->products as $obj)
						{
							$model->unlink('products', $obj, true);
						}
					}
					
					/*** Удаляем связанные характеристики ***/
					Feature::deleteAll(['module' => Module::getInstance()->id, 'content_id' => $id]);
					
					/*** Удаляем связанные опции ***/
					Option::deleteAll(['module' => Module::getInstance()->id, 'content_id' => $id]);
					
					/*** Удаляем сам материал ***/
					$model->delete();
					/*** Удаляем файлы и записи из таблицы file ***/
					$fileModel->deleteFiles($id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
					/*** Удаляем записи из таблицы seo ***/
					$seoModel->deleteSeo($id, Module::getInstance()->id);
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
		if (($model = Product::findOne($id)) !== null) {
			return $model;
		} else {
			return false;
		}
	}
	
    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested product does not exist.');
        }
    }
	
	protected function findAllActionItems()
    {
        return Action::find()->where(['is_main' => 0])->all();
    }
	
	protected function findAllCatalogItems()
    {
        return Catalog::find()->where(['is_main' => 0])->all();
    }
	
	protected function findAllProductItems()
    {
        return Product::find()->where(['is_main' => 0])->all();
    }
	
	protected function findFeatures($id)
    {
        return Feature::find()->where(['content_id' => $id, 'module' => Module::getInstance()->id])->orderBy('weight')->all();
    }
	
	protected function findOptions($id)
    {
		$type = [];
		$type_data = Option::getOptionTypesArray();
		
		foreach($type_data as $type_id => $type_name)
		{
			$optionData = Option::find()->where(['option_type' => $type_id, 'module' => Module::getInstance()->id, 'content_id' => $id])->orderBy('weight')->all();
			if ($optionData) 
			{
				$type[$type_id] = $optionData;
			}
		}
        return $type;
    }
}