<?php

namespace app\modules\main\controllers\backend;

use app\controllers\BackendController;

/**
 * Default controller for the `main` module
 */
class MainController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('/backend/index');
		return $this->redirect(['/admin/main']);
    }
}
