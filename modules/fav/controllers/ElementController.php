<?php
namespace app\modules\fav\controllers;

use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii;

class ElementController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionDelete()
    {
        $json = ['result' => 'undefined', 'error' => false];
        $elementId = yii::$app->request->post('elementId');

        $fav = yii::$app->fav;

        $elementModel = $fav->getElementById($elementId);

        if($fav->deleteElement($elementModel)) {
            $json['result'] = 'success';
        }
        else {
            $json['result'] = 'fail';
        }

        return $this->_favJson($json);
    }

    public function actionCreate()
    {
        $json = ['result' => 'undefined', 'error' => false];

        $fav = yii::$app->fav;

        $postData = yii::$app->request->post();

        $model = $postData['FavElement']['model'];
        if($model) {
            $productModel = new $model();
            $productModel = $productModel::findOne($postData['FavElement']['item_id']);

            if($postData['FavElement']['price'] && $postData['FavElement']['price'] != 'false') {
                $elementModel = $fav->putWithPrice($productModel, $postData['FavElement']['price'], $postData['FavElement']['count']);
            } else {
                $elementModel = $fav->put($productModel, $postData['FavElement']['count']);
            }

            $json['elementId'] = $elementModel->getId();
            $json['result'] = 'success';
        } else {
            $json['result'] = 'fail';
            $json['error'] = 'empty model';
        }

        return $this->_favJson($json);
    }

    public function actionUpdate()
    {
        $json = ['result' => 'undefined', 'error' => false];

        $fav = yii::$app->fav;
        
        $postData = yii::$app->request->post();

        $elementModel = $fav->getElementById($postData['FavElement']['id']);
        
        if(isset($postData['FavElement']['count'])) {
            $elementModel->setCount($postData['FavElement']['count'], true);
        }
        
        $json['elementId'] = $elementModel->getId();
        $json['result'] = 'success';

        return $this->_favJson($json);
    }

    private function _favJson($json)
    {
        if ($favModel = yii::$app->fav) {
            if(!$elementsListWidgetParams = yii::$app->request->post('elementsListWidgetParams')) {
                $elementsListWidgetParams = [];
            }

            $json['elementsHTML'] = '';
            $json['count'] = $favModel->getCount();
            $json['clear_price'] = $favModel->getCount(false);
            $json['price'] = $favModel->getCostFormatted();
        } else {
            $json['count'] = 0;
            $json['price'] = 0;
            $json['clear_price'] = 0;
        }
        return Json::encode($json);
    }

}
