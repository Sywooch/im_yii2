<?php
namespace app\modules\profile\controllers\backend;
use Yii;
/********** USE MODELS *********/
use app\modules\profile\models\Profile;
use app\modules\file\models\File;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\profile\Module;
/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' profile.
     * @return mixed
     */
    public function actionCreate($user_id)
    {
        $model = new Profile();
		
		$this->post = Yii::$app->request->post();
		
		$model->user_id = $user_id; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			
			/*** Редактирование (добавление) файлов для галереи ***/
			$fileModel = new File();
			$fileModel->updateFiles($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			return $this->redirect(['view', 'id' => $model->id]);
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
		$this->post = Yii::$app->request->post();
		
		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			/*** Редактирование (добавление) файлов для галереи ***/
			$fileModel = new File();
			$fileModel->updateFiles($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
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
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' profile.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$this->post = Yii::$app->request->post();
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			/*** Редактирование (добавление) файлов для галереи ***/
			$fileModel = new File();
			$fileModel->updateFiles($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);
			return $this->redirect(['view', 'id' => $id]);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' profile.
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
        return $this->redirect(['/admin/user/view', 'id' => $model->user_id]);
    }
    
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested portfolio does not exist.');
        }
    }
}