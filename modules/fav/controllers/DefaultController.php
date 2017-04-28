<?php
namespace app\modules\fav\controllers;

use app\controllers\FrontendController;

use app\modules\fav\models\Fav;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii;

class DefaultController extends FrontendController
{
   /*  public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'truncate' => ['post'],
                ],
            ],
        ];
    } */

    public function actionIndex()
    {
		$this->view->params['page_class'] = '';
		$this->view->title = 'Отложенные товары';
		$this->view->params['title_h1'] = 'Отложенные товары';
		
        $elements = yii::$app->fav->elements;

        return $this->render('index', [
            'elements' => $elements,
        ]);
    }

    public function actionTruncate()
    {
        $json = ['result' => 'undefined', 'error' => false];

        $favModel = yii::$app->fav;
        
        if ($favModel->truncate()) {
            $json['result'] = 'success';
        } else {
            $json['result'] = 'fail';
            $json['error'] = $favModel->getFav()->getErrors();
        }

        return $this->_favJson($json);
    }

    public function actionInfo() {
        return $this->_favJson();
    }
    
    private function _favJson($json)
    {
        if ($favModel = yii::$app->fav) {
            $json['elementsHTML'] = '';
            $json['count'] = $favModel->getCount();
            $json['price'] = $favModel->getCostFormatted();
        } else {
            $json['count'] = 0;
            $json['price'] = 0;
        }
        return Json::encode($json);
    }
}
