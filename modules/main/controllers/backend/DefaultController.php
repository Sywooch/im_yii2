<?php

namespace app\modules\main\controllers\backend;

use app\controllers\BackendController;

use Yii;

/********** USE MODELS *********/
use app\modules\main\models\Siteinfo;
use app\modules\seo\models\Seo;
use app\modules\file\models\File;

use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\main\Module;

/**
 * SiteinfoController implements the CRUD actions for siteinfo model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all siteinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
		$id = 1;
        return $this->render('/backend/siteinfo/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single siteinfo model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id = 1)
    {
        return $this->render('/backend/siteinfo/view', [
            'model' => $this->findModel($id),
        ]);
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

            /*** Редактирование (добавление) Логотипа ***/
            $fileModel = new File();
            $fileModel->updateLogo($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);

            /*** Редактирование (добавление) Иконки ***/
            $fileModel->updateIcon($this->post, $model, $model->id);

            return $this->redirect([$this->post['popup_edit_redirect']]); // Возвращаемся на предыдущую страницу
        }
        else
        {
            return $this->renderAjax('/backend/siteinfo/update-fast', [
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

            $this->post = Yii::$app->request->post();

            /*** Редактирование (добавление) Логотипа ***/
            $fileModel = new File();
            $fileModel->updateLogo($this->post, $model, $model->id, Module::getInstance()->id, Module::getInstance()->imagesDirectory);

            /*** Редактирование (добавление) Иконки ***/
            $fileModel->updateIcon($this->post, $model, $model->id);

            /*** Редактирование SEO ***/
            $seoModel = new Seo();
            $seoModel->updateSeo($this->post, $model->id, Module::getInstance()->id);

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('/backend/siteinfo/update', [
                'model' => $model,
            ]);
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
        if (($model = Siteinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
