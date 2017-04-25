<?php

namespace app\modules\shipping\controllers;

use app\controllers\FrontendController;

use app\modules\shipping\models\Shipping;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use app\modules\shipping\Module;
use Yii;
/**
 * Default controller for the `shipping` module
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