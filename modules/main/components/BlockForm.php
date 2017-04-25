<?php

namespace app\modules\main\components;

use Yii;
use app\modules\main\models\forms\FormContact;
use app\modules\main\models\forms\FormRecall;
use app\modules\main\models\forms\FormAction;
use app\modules\main\models\forms\FormProduct;
use app\modules\user\models\User;
use app\modules\profile\models\Profile;

class BlockForm
{
	public static function _contact()
	{
		$model = new FormContact();
		if (!Yii::$app->user->isGuest) 
		{
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
				$model->name = $profileModel->name;
				$model->phone = $profileModel->phone;
			}
		}
		return Yii::$app->view->renderFile('@app/modules/main/views/block-form-contact.php', ['model' => $model]);
	}
	
	public static function _recall()
	{
		$model = new FormRecall();
		if (!Yii::$app->user->isGuest) 
		{
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
				$model->name = $profileModel->name;
				$model->phone = $profileModel->phone;
			}
		}
		return Yii::$app->view->renderFile('@app/modules/main/views/block-form-recall.php', ['model' => $model]);
	}
	
	public static function _action()
	{
		$model = new FormAction();
		if (!Yii::$app->user->isGuest) 
		{
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
				$model->name = $profileModel->name;
				$model->phone = $profileModel->phone;
				$model->email = Yii::$app->user->identity->email;
			}
		}
		return Yii::$app->view->renderFile('@app/modules/main/views/block-form-action.php', ['model' => $model]);
	}
	
	public static function _product()
	{
		$model = new FormProduct();
		if (!Yii::$app->user->isGuest) 
		{
			if(Yii::$app->user->identity->profile)
			{
				$profileModel = Profile::findOne(Yii::$app->user->identity->profile->id);
				$model->name = $profileModel->name;
				$model->phone = $profileModel->phone;
				$model->email = Yii::$app->user->identity->email;
			}
		}
		return Yii::$app->view->renderFile('@app/modules/main/views/block-form-product.php', ['model' => $model]);
	}
}