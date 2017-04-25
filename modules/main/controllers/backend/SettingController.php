<?php

namespace app\modules\main\controllers\backend;

use app\controllers\BackendController;

use Yii;

/********** USE MODELS *********/
use app\modules\main\models\Setting;
use app\modules\main\models\SettingSearch;

use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

use app\modules\main\Module;

/**
 * SiteinfoController implements the CRUD actions for siteinfo model.
 */
class SettingController extends BackendController
{
    /**
     * Lists all siteinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
		$newModel = new Setting();
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('/backend/setting/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'newModel' => $newModel,
        ]);
    }
	
	/**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();
        if ($model->load(Yii::$app->request->post()) && $model->save())
		{
            return $this->redirect(['index']);
        } 
		else 
		{
            return $this->render('/backend/setting/create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreateFast()
    {
        $model = new Setting();
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('/backend/setting/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing siteinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
            return $this->redirect(['index']);

        } else {
            return $this->render('/backend/setting/update', [
                'model' => $model,
            ]);
        }
    }
	
	/**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
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
                    /*** Удаляем сам материал ***/
                    $this->findModel($id)->delete();
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
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * Finds the siteinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return siteinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
