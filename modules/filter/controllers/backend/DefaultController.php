<?php
namespace app\modules\filter\controllers\backend;
use Yii;
use app\modules\filter\models\Filter;
use app\modules\filter\models\FilterSearch;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use app\modules\filter\Module;
use kartik\grid\EditableColumnAction;
/**
 * FilterController implements the CRUD actions for Filter model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Filter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $newModel = new Filter();
        $searchModel = new FilterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newModel' => $newModel,
        ]);
    }
    /**
     * Displays a single Filter model.
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
     * Creates a new Filter model.
     * If creation is successful, the browser will be redirected to the 'view' filter.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Filter();
		$model->status = 1; // Значение поля по умолчанию
		$model->weight = 0; // Значение поля по умолчанию
        if ($model->load(Yii::$app->request->post()) AND $model->save()) 
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
     * Updates an existing Filter model.
     * If update is successful, the browser will be redirected to the 'view' filter.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) AND $model->save()) 
		{
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
     * Deletes an existing Filter model.
     * If deletion is successful, the browser will be redirected to the 'index' filter.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		// Удаляем сам материал
		$model->delete();
		
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
                    // Удаляем сам материал
                    $model->delete();
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
        if (($model = Filter::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }
    /**
     * Finds the Filter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Filter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Filter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested filter does not exist.');
        }
    }
}