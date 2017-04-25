<?php

namespace app\modules\payment\controllers;

use app\controllers\FrontendController;

use app\modules\payment\models\Payment;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use app\modules\payment\Module;
use Yii;
/**
 * Default controller for the `payment` module
 */
class DefaultController extends FrontendController
{
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		
    }
}