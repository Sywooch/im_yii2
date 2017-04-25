<?php
namespace app\modules\option\controllers\backend;
use Yii;

/********** USE MODELS *********/
use app\modules\option\models\Option;
use app\modules\file\models\File;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\option\Module;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Option models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Displays a single Option model.
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
     * Creates a new Option model.
     * If creation is successful, the browser will be redirected to the 'view' option.
     * @return mixed
     */
    public function actionCreate($content_id, $module = 'product', $redirect = 'update')
    {
        $model = new Option();
		$this->post = Yii::$app->request->post();
		$model->content_id = $content_id; // Значение поля по умолчанию
		$model->module = $module; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			
			return $this->redirect(['/admin/'.$module.'/'.$redirect, 'id' => $content_id]);
        } 
		else 
		{
            return $this->render('/backend/create', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Updates an existing Option model.
     * If update is successful, the browser will be redirected to the 'view' option.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		$this->post = Yii::$app->request->post();
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			/*** Редактирование (добавление) картинки миниатюры ***/
			$fileModel = new File();
			$fileModel->updateThumb($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			
			return $this->redirect(['/admin/'.$this->post['Option']['module'].'/'.$redirect, 'id' => $this->post['Option']['content_id']]);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Deletes an existing Option model.
     * If deletion is successful, the browser will be redirected to the 'index' option.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		
		/*** Удаляем сам материал ***/
		$model->delete();
		
		/*** Удаляем файлы и записи из таблицы file ***/
		$fileModel = new File();
        $fileModel->deleteFiles($id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
		
        return $this->redirect(['/admin/'.$model->module.'/'.$redirect, 'id' => $model->content_id]);
    }
    
    protected function findModel($id)
    {
        if (($model = Option::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested option does not exist.');
        }
    }
}