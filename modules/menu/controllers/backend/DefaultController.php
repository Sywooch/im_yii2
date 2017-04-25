<?php

namespace app\modules\menu\controllers\backend;

use Yii;
use app\modules\menu\models\Menu;

use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\data\ActiveTreeDataProvider;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
		$type = [];
		$type_data = Menu::getTypeMenuArray();
		
        $newModel = new Menu();
		
		foreach($type_data as $type_id => $type_name)
		{
			$query = Menu::find()->where(['type_id' => $type_id])->orderBy('weight'); // Сортировка по умолчанию по полю "weight"
			$parent_data = new ActiveTreeDataProvider([
				'query' => $query,
				'isMany' => false, // Множественный выбор отключен, идентификация родительского элемента осуществляется по полю parent_id
				'pagination' => [
					'pageSize' => 100, // количество материалов на странице
				],
			]);
			
			if ($parent_data) 
			{
				$type[$type_id] = $parent_data;
			}
		}
		
        return $this->render('/backend/index', [
            'data' => $type,
            'newModel' => $newModel,
            'selectItems' => $this->findItems(),
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
		
		$model->status = 1; // Значение поля по умолчанию
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('/backend/create', [
                'model' => $model,
				'selectItems' => $this->findItems(),
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
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
				'selectItems' => $this->findItems(),
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		// Ищем вложенные материалы и переопределяем в корневые
		Menu::updateAll(['parent_id' => 0], 'parent_id = '.$id);
        $this->findModel($id)->delete();
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
                    Menu::updateAll(['parent_id' => 0], 'parent_id = '.$id);
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
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findParentItems($parentId = 0)
    {
        return Menu::find()->where(['parent_id' => $parentId, 'type_id' => 0])->orderBy('weight')->all();
    }
	
	protected function findItems()
    {
		return Menu::find()->where(['type_id' => 0])->orderBy('weight')->all();
    }
}