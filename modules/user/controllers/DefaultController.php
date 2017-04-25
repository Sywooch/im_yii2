<?php

namespace app\modules\user\controllers;

use app\controllers\FrontendController;
 
use app\modules\user\models\forms\FormEmailConfirm;
use app\modules\user\models\forms\FormLogin;
use app\modules\user\models\forms\FormPasswordReset;
use app\modules\user\models\forms\FormPasswordResetRequest;
use app\modules\user\models\forms\FormPasswordChange;
use app\modules\user\models\forms\FormSignup;
use app\modules\user\models\User;
use app\modules\profile\models\Profile;
use app\modules\file\models\File;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

use Yii;
 
class DefaultController extends FrontendController
{
	public function actionIndex()
    {
		$post = Yii::$app->request->post();
		
		/********************************* Личный кабинет ***********************************/
        if (!Yii::$app->user->isGuest) 
		{
			$profileModel = false;
			
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
			}
			
			$userModel = User::findOne(Yii::$app->user->identity->id);
			
			$passwordModel = new FormPasswordChange($userModel);
			
			if ($passwordModel->load($post)) {
				$passwordModel->changePassword();
				Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменен!');
			}
			
			if ($userModel->load($post)) 
			{
				$userModel->save();
			}
		
			if ($profileModel && $profileModel->load($post)) 
			{
				$profileModel->attributes = $post['Profile'];
			
				if ($profileModel->save()) 
				{
					/*** Редактирование (добавление) файлов для галереи ***/
					$fileModel = new File();
					$fileModel->updateFiles($post, $profileModel, $profileModel->id, 'profile', 'profile');
					
					Yii::$app->getSession()->setFlash('success', 'Изменения профиля сохранены.');
				} 
				else 
				{
					$errors = $profileModel->errors;
					Yii::$app->getSession()->setFlash('error', print_r($errors));
				}
				return $this->redirect(['/account']);
			}
			
			$this->view->title = 'Личный кабинет';
				
            return $this->render('/profile', [
				'profileModel' => $profileModel,
				'userModel' => $userModel,
				'passwordModel' => $passwordModel,
			]);
        }
 
		/********************************* Регистрация, Авторизация, Восстановление пароля ***********************************/
        $loginModel = new FormLogin();
		$signupModel = new FormSignup($this->module->defaultRole);
		$profileModel = new Profile();
		$resetModel = new FormPasswordResetRequest();
		
        if ($loginModel->load($post) && $loginModel->login()) 
		{
            return $this->goHome();// На главную //$this->goBack(); // по введенному адресу, в админку
		} 
		elseif ($signupModel->load($post)) 
		{
            if ($user = $signupModel->signup()) 
			{
				if ($profileModel->load($post)) 
				{
					$profileModel->user_id = $user->id;
					
					$profileModel->attributes = $post['Profile'];
				
					if ($profileModel->save()) 
					{
						/*** Редактирование (добавление) файлов для галереи ***/
						$fileModel = new File();
						$fileModel->updateFiles($post, $profileModel, $profileModel->id, 'profile', 'profile');
						
						Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
					} 
					else 
					{
						$errors = $profileModel->errors;
						Yii::$app->getSession()->setFlash('error', print_r($errors));
					}
				}
                return $this->redirect(['/account']);
            }
		
		} 
		elseif ($resetModel->load($post) && $resetModel->validate()) 
		{
            if ($resetModel->sendEmail()) 
			{
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
                return $this->redirect(['/account']);
            } 
			else 
			{
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        } 
		else 
		{
            return $this->render('/index', [
                'loginModel' => $loginModel,
				'signupModel' => $signupModel,
				'profileModel' => $profileModel,
				'resetModel' => $resetModel,
            ]);
        }
    }
 
    public function actionLogin()
    {
		$this->layout = '/popup';
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 
        $model = new FormLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();// На главную //$this->goBack(); // по введенному адресу, в админку
        } else {
            return $this->render('/popup/login', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUserLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$this->view->title = 'Авторизация';
		
        $model = new FormLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();// На главную //$this->goBack(); // по введенному адресу, в админку
        } else {
            return $this->render('/login', [
                'model' => $model,
            ]);
        }
    }
 
    public function actionLogout()
    {
        Yii::$app->user->logout();
 
        return $this->goHome();
    }
 
    public function actionSignup()
    {
		$post = Yii::$app->request->post();
		
		$profileModel = new Profile();
        $model = new FormSignup($this->module->defaultRole);
		
        if ($model->load($post)) {
            if ($user = $model->signup()) {
				if ($profileModel->load($post)) 
				{
					$profileModel->user_id = $user->id;
					
					$profileModel->attributes = $post['Profile'];
				
					if ($profileModel->save()) 
					{
						Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
					} 
					else 
					{
						$errors = $profileModel->errors;
						Yii::$app->getSession()->setFlash('error', print_r($errors));
					}
				}
                return $this->goHome();
            }
        }
 
		$this->view->title = 'Регистрация';
		
        return $this->render('/signup', [
            'model' => $model,
			'profileModel' => $profileModel,
        ]);
    }
 
    public function actionEmailConfirm($token)
    {
        try {
            $model = new FormEmailConfirm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }
 
        return $this->goHome();
    }
 
    public function actionPasswordResetRequest()
    {
		//$this->layout = '/popup';
		
        $model = new FormPasswordResetRequest();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
 
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        }
		
		$this->view->title = 'Восстановление пароля';
 
        return $this->render('/passwordResetRequest', [
            'model' => $model,
        ]);
    }
 
    public function actionPasswordReset($token)
    {
		//$this->layout = '/popup';
		
        try {
            $model = new FormPasswordReset($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');
 
            return $this->goHome();
        }
		
		$this->view->title = 'Сброс пароля';
 
        return $this->render('/passwordReset', [
            'model' => $model,
        ]);
    }
	
	protected function findCurrentZones($model)
    {
		if($model)
		{
			return Zone::find()->where(['city_id' => $model->city_id])->orderBy('title')->all();
		}
		else
		{
			return false;
		}
    }
	
	protected function findActiveZoneIds($model)
    {
		if($model)
		{
			$currentZoneIds = $model->getZones()->select('id')->column();
			$currentZoneIdsArray = [];
			if($currentZoneIds)
			{
				foreach($currentZoneIds as $currentZoneId)
				{
					$currentZoneIdsArray[$currentZoneId] = $currentZoneId;
				}
			}
			return $currentZoneIdsArray;
		}
		else
		{
			return false;
		}
    }
}