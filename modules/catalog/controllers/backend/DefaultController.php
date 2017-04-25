<?php

namespace app\modules\catalog\controllers\backend;
use Yii;

/********** USE MODELS *********/
use app\modules\catalog\models\Catalog;
use app\modules\catalog\models\CatalogSearch;
use app\modules\file\models\File;
use app\modules\seo\models\Seo;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\catalog\Module;
use yii\helpers\Url;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Catalog models.
     * @return mixed
     */
    public function actionIndex()
    {
		$mainModel = Catalog::find()->where(['is_main' => 1])->one();
		
        $newModel = new Catalog();
		$searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('/backend/index', [
			'newModel' => $newModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'selectItems' => $this->findItems(),
			'mainModel' => $mainModel,
        ]);
    }
	
    /**
     * Displays a single Catalog model.
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
     * Creates a new Catalog model.
     * If creation is successful, the browser will be redirected to the 'view' catalog.
     * @return mixed
     */
    public function actionCreateFast()
    {
        $model = new Catalog();
        $model->status = 1; // Значение поля по умолчанию
        $model->weight = 0; // Значение поля по умолчанию
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('/backend/create', [
                'model' => $model,
				'selectItems' => $this->findItems()
            ]);
        }
    }
	
    /**
     * Creates a new Catalog model.
     * If creation is successful, the browser will be redirected to the 'view' catalog.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Catalog();
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
				'selectItems' => $this->findItems(),
            ]);
        }
    }
	
	public function actionCreateMain()
    {
        $model = new Catalog();
		
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
				'selectItems' => $this->findItems()
            ]);
        }
    }
	
    /**
     * Updates an existing Catalog model.
     * If update is successful, the browser will be redirected to the 'view' catalog.
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
				'selectItems' => $this->findItems(),
            ]);
        }
    }
	
    /**
     * Deletes an existing Catalog model.
     * If deletion is successful, the browser will be redirected to the 'index' catalog.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		/*** Ищем вложенные материалы и переопределяем в корневые ***/
		Catalog::updateAll(['parent_id' => 0], 'parent_id = '.$id);
        $model = $this->findModel($id);
		
		/*** Удаляем записи из связанной таблицы catalog_catalog ***/
		if($model->children)
		{
			foreach($model->children as $obj)
			{
				$model->unlink('children', $obj, true);
			}
		}
		
		/*** Удаляем сам материал ***/
		$model->delete();
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
                $fileModel = new File();
                $seoModel = new Seo();
                foreach($arrKey as $id)
                {
                    /*** Ищем вложенные материалы и переопределяем в корневые ***/
                    Catalog::updateAll(['parent_id' => 0], 'parent_id = '.$id);
                    $model = $this->findModel($id);
					
					/*** Удаляем записи из связанной таблицы catalog_catalog ***/
					if($model->children)
					{
						foreach($model->children as $obj)
						{
							$model->unlink('children', $obj, true);
						}
					}
                    
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
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }
	
    /**
     * Finds the Catalog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Catalog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested catalog does not exist.');
        }
    }
	
	protected function findItems()
    {
		return Catalog::find()->where(['is_main' => 0])->orderBy('weight')->all();
    }
}