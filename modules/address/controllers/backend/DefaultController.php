<?php
namespace app\modules\address\controllers\backend;
use Yii;

/********** USE MODELS *********/
use app\modules\address\models\Address;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\address\Module;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Address models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Displays a single Address model.
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
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' address.
     * @return mixed
     */
    public function actionCreate($user_id, $redirect = 'update')
    {
        $model = new Address();
		$this->post = Yii::$app->request->post();
		$model->user_id = $user_id; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			return $this->redirect(['/admin/user/'.$redirect, 'id' => $user_id]);
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
     * Updates an existing Address model.
     * If update is successful, the browser will be redirected to the 'view' address.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		$this->post = Yii::$app->request->post();
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			return $this->redirect(['/admin/user/'.$redirect, 'id' => $this->post['Address']['user_id']]);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' address.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		
		/*** Удаляем сам материал ***/
		$model->delete();
        return $this->redirect(['/admin/user/'.$redirect, 'id' => $model->user_id]);
    }
    
    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested address does not exist.');
        }
    }
}