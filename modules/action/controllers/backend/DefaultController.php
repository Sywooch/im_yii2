<?php

namespace app\modules\action\controllers\backend;

use Yii;

/********** USE MODELS *********/
use app\modules\action\models\Action;
use app\modules\action\models\ActionSearch;
use app\modules\file\models\File;
use app\modules\seo\models\Seo;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;

use app\modules\action\Module;
use kartik\grid\EditableColumnAction;

use yii\helpers\Url;

/**
 * ActionController implements the CRUD actions for Action model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Action models.
     * @return mixed
     */
    public function actionIndex()
    {
		$mainModel = Action::find()->where(['is_main' => 1])->one();
		
        $newModel = new Action();
        $searchModel = new ActionSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newModel' => $newModel,
			'mainModel' => $mainModel,
        ]);
    }
	
    /**
     * Displays a single Action model.
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
     * Creates a new Action model.
     * If creation is successful, the browser will be redirected to the 'view' action.
     * @return mixed
     */
    public function actionCreateFast()
    {
        $model = new Action();
        $model->status = 1; // Значение поля по умолчанию
        $model->weight = 0; // Значение поля по умолчанию
        $model->date = date('Y-m-d'); // Значение поля по умолчанию

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
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
     * Creates a new Action model.
     * If creation is successful, the browser will be redirected to the 'view' action.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Action();
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию
        $model->date = date('Y-m-d'); // Значение поля по умолчанию

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
            ]);
        }
    }
	
	public function actionCreateMain()
    {
        $model = new Action();
		
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
            ]);
        }
    }

    /**
     * Updates an existing Action model.
     * If update is successful, the browser will be redirected to the 'view' action.
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
            ]);
        }
    }
    /**
     * Deletes an existing Action model.
     * If deletion is successful, the browser will be redirected to the 'index' action.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
                    $this->findModel($id)->delete();

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
        if (($model = Action::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * Finds the Action model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Action the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Action::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested action does not exist.');
        }
    }
}