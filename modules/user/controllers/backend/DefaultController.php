<?php
namespace app\modules\user\controllers\backend;
use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\profile\models\Profile;
use app\modules\user\models\forms\FormUserAdd;
use app\modules\user\models\forms\FormPasswordChange;
use app\controllers\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultController extends BackendController
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('/backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/backend/view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$profileModel = new Profile();
        $model = new FormUserAdd();
		
		$model->status = 1; // Значение поля по умолчанию
		
        if ($model->load(Yii::$app->request->post()) && $id = $model->save()) {
			
			if ($profileModel->load(Yii::$app->request->post())) 
			{
				$profileModel->user_id = $id;
				//$profileModel->email = $model->email;
				
				$profileModel->attributes = Yii::$app->request->post('Profile');
				$profileModel->save();
			}
			
            return $this->redirect(['view', 'id' => $id]);
			
        } else {
            return $this->render('/backend/create', [
                'model' => $model,
				'profileModel' => $profileModel,
            ]);
        }
    }
	
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$profileModel = Profile::find()->where(['user_id' => $id])->one();
		
		if(!$profileModel)
		{
			$profileModel = new Profile();
		}
		
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			if ($profileModel->load(Yii::$app->request->post())) 
			{
				$profileModel->user_id = $id;
				//$profileModel->email = $model->email;
				$profileModel->attributes = Yii::$app->request->post('Profile');
				$profileModel->save();
			}
			
            return $this->redirect(['view', 'id' => $model->id]);
			
        } else {
            return $this->render('/backend/update', [
                'model' => $model,
				'profileModel' => $profileModel,
            ]);
        }
    }
	
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		Profile::deleteAll(['user_id' => $id]);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
	
	/**
     * Password change
     */
	public function actionPasswordChange($id)
    {
        $user = $this->findModel($id);
        $model = new FormPasswordChange($user);
 
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('/backend/passwordChange', [
                'model' => $model,
				'user' => $user,
            ]);
        }
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}