<?php
namespace app\modules\address\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\address\models\Address;
use app\controllers\FrontendController;
use yii\web\NotFoundHttpException;
use app\modules\address\Module;

/**
 * Default controller for the `address` module
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
        $address = Address::find()->where(['id' => $id])->one();
		
		if ($address) 
		{
            $this->view->title = $address->name;
			return $this->render('/view', [
				'address' => $address
			]);
        } 
		else 
		{
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
}