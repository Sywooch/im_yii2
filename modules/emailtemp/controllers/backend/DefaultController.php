<?php

namespace app\modules\emailtemp\controllers\backend;

use Yii;
use app\modules\emailtemp\models\Emailtemp;
use app\modules\emailtemp\models\EmailtempSearch;
use yii\data\ActiveDataProvider;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;

/**
 * EmailtempController implements the CRUD actions for Emailtemp model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Emailtemp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailtempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Emailtemp model.
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
     * Creates a new Emailtemp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Emailtemp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('/backend/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Emailtemp model.
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
            return $this->render('/backend/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Emailtemp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Emailtemp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Emailtemp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Emailtemp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
