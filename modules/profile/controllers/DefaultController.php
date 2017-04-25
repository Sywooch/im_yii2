<?php
namespace app\modules\profile\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\profile\models\Profile;
use app\controllers\FrontendController;
use yii\web\NotFoundHttpException;
use app\modules\profile\Module;

/**
 * Default controller for the `profile` module
 */
class DefaultController extends FrontendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$this->view->params['page_class'] = '';
		
        return $this->render('/index', [
            
        ]);
    }
	
	public function actionView($id)
    {
		$this->view->params['page_class'] = '';
        $profile = Profile::find()->where(['id' => $id])->one();
		
		if ($profile) 
		{
            $this->view->title = $profile->name;
			return $this->render('/view', [
				'profile' => $profile
			]);
        } 
		else 
		{
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
}