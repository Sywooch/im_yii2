<?php

namespace app\modules\review\controllers\backend;

use Yii;

/********** USE MODELS *********/
use app\modules\review\models\Review;
use app\modules\review\models\ReviewSearch;
use app\modules\file\models\File;
use app\modules\seo\models\Seo;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;

use app\modules\review\Module;
use kartik\grid\EditableColumnAction;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        $newModel = new Review();
        $searchModel = new ReviewSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $clientsItems = $this->findAllClientsItems();

        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newModel' => $newModel,
        ]);
    }

    /**
     * Displays a single Review model.
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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' review.
     * @return mixed
     */
    public function actionCreateFast()
    {
        $model = new Review();

        $model->status = 1; // Значение поля по умолчанию
        $model->weight = 0; // Значение поля по умолчанию

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->post = Yii::$app->request->post();

            if(empty($model->client_id)){
                $model->client_id = 0; // Значение поля по умолчанию
            }

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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' review.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Review();
		
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию

        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
            $this->post = Yii::$app->request->post();

			if(empty($model->client_id)){
				$model->client_id = 0; // Значение поля по умолчанию
			}

            /*** Редактирование (добавление) картинки миниатюры ***/
            $fileModel = new File();
            $fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);

            /*** Редактирование SEO ***/
            $seoModel = new Seo();
            $seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);

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
     * Fast Update in Popup window
     */
    public function actionUpdateFast($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            if(empty($model->client_id)){
                $model->client_id = 0; // Значение поля по умолчанию
            }

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
            ]);
        }
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' review.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			if(empty($model->client_id)){
				$model->client_id = 0; // Значение поля по умолчанию
			}

            $this->post = Yii::$app->request->post();

            /*** Редактирование (добавление) картинки миниатюры ***/
            $fileModel = new File();
            $fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);

            /*** Редактирование SEO ***/
            $seoModel = new Seo();
            $seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);

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
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' review.
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
                    $model = $this->findModel($id);
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
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested review does not exist.');
        }
    }
}
