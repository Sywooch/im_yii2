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
		if($this->validateDeleteUser($id))
		{
			Profile::deleteAll(['user_id' => $id]);
			$this->findModel($id)->delete();
		}
		else
		{
			Yii::$app->getSession()->setFlash('danger', $this->errorMessage);
		}
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
					if($this->validateDeleteUser($id))
					{
						Profile::deleteAll(['user_id' => $id]);
						$this->findModel($id)->delete();
					}
					else
					{
						Yii::$app->getSession()->setFlash('danger', $this->errorMessage);
					}
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
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
	
	/**
     * Проверка удаляемого пользователя.
     * Нельзя удалить себя и нельзя удалить последнего в системе админа.
     */
	protected function validateDeleteUser($id)
    {
		$return = true;
		if(Yii::$app->user->identity->id == $id){
			$return = false;
			$this->errorMessage .= '<p>'.Yii::$app->user->identity->username.' - Удаление невозможно, так как вы авторизованы как этот пользователь.</p>';
		}
        if (User::find()->where(['role' => 'admin'])->count() < 2) {
            $return = false;
			$this->errorMessage .= '<p>'.Yii::$app->user->identity->username.' - Удаление невозможно, так как в системе не должено оставаться меньше одного администратора.</p>';
        }
		return $return;
    }
}