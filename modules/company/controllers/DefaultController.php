<?php
namespace app\modules\company\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\company\models\Company;
use app\controllers\FrontendController;
use yii\web\NotFoundHttpException;
use app\modules\company\Module;

/**
 * Default controller for the `company` module
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
        $company = Company::find()->where(['id' => $id])->one();
		
		if ($company) 
		{
            $this->view->title = $company->name;
			return $this->render('/view', [
				'company' => $company
			]);
        } 
		else 
		{
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
}