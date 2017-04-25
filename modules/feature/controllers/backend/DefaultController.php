<?php
namespace app\modules\feature\controllers\backend;
use Yii;

/********** USE MODELS *********/
use app\modules\feature\models\Feature;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\feature\Module;

/**
 * FeatureController implements the CRUD actions for Feature model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Feature models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Displays a single Feature model.
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
     * Creates a new Feature model.
     * If creation is successful, the browser will be redirected to the 'view' feature.
     * @return mixed
     */
    public function actionCreate($content_id, $module = 'product', $redirect = 'update')
    {
        $model = new Feature();
		$this->post = Yii::$app->request->post();
		$model->content_id = $content_id; // Значение поля по умолчанию
		$model->module = $module; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
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
     * Updates an existing Feature model.
     * If update is successful, the browser will be redirected to the 'view' feature.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		$this->post = Yii::$app->request->post();
		
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			return $this->redirect(['/admin/'.$this->post['Feature']['module'].'/'.$redirect, 'id' => $this->post['Feature']['content_id']]);
        } 
		else 
		{
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }
	
    /**
     * Deletes an existing Feature model.
     * If deletion is successful, the browser will be redirected to the 'index' feature.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $redirect = 'update')
    {
        $model = $this->findModel($id);
		
		/*** Удаляем сам материал ***/
		$model->delete();
        return $this->redirect(['/admin/'.$model->module.'/'.$redirect, 'id' => $model->content_id]);
    }
    
    protected function findModel($id)
    {
        if (($model = Feature::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested feature does not exist.');
        }
    }
}