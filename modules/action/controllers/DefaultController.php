<?php

namespace app\modules\action\controllers;

use app\controllers\FrontendController;
use app\modules\action\models\Action;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

use yii\data\ActiveDataProvider;

use Yii;

/**
 * Default controller for the `action` module
 */
class DefaultController extends FrontendController
{
	/**
     * Renders the view for the module
     * @return string
     */
    public function actionView($alias = '')
    {
		$action = Action::find()->where(['status' => 1, 'alias' => $alias])->one();
		
		if ($action) 
		{
			$search = '[ORDER_BUTTON]';
			$replace = '<a class="button" onclick="addOrderAction('.$action->id.', \''.htmlspecialchars($action->short_title).'\');">Участвовать в акции</a>';
		
			$action->body = str_replace($search, $replace, $action->body);
		
            $this->view->title = $action->title;
			
			/******************** SEO ************************/
			if($action->seo) {
				if (!empty($action->seo->meta_title)) {
					$this->view->title = $action->seo->meta_title;
				}

				if (!empty($action->seo->meta_desc)) {
					$this->view->params['meta_description'] = $action->seo->meta_desc;
				}

				if (!empty($action->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $action->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
			
			return $this->render('/action', ['action' => $action]);
			
        } 
		else 
		{
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
	
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		$this->processPageRequest('page');
		
		$query = Action::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => DEFAULT_FRONT_PAGE_SIZE
			],
        ]);
		
		$query->andFilterWhere(['is_main' => 0])
			->andFilterWhere(['status' => 1])
			->orderBy(['date' => SORT_DESC]);
			
		$actions = $dataProvider->getModels();
		//$pagination = $dataProvider->getPagination();
		
		$mainAction = Action::find()->where(['is_main' => 1])->one();
		
		if ($actions) {
		
            $this->view->title = 'Акции';
			$this->view->params['title_h1'] = 'Акции';
			
			/******************** SEO ************************/
			if($mainAction && $mainAction->seo) {
				if (!empty($mainAction->seo->meta_title)) {
					$this->view->title = $mainAction->seo->meta_title;
				}
				if (!empty($mainAction->seo->title_h1)) {
					$this->view->params['title_h1'] = $mainAction->seo->title_h1;
				}
				if (!empty($mainAction->seo->meta_desc)) {
					$this->view->params['meta_description'] = $mainAction->seo->meta_desc;
				}
				if (!empty($mainAction->seo->meta_key)) {
					$this->view->params['meta_keywords'] = $mainAction->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
        }
		
		if (Yii::$app->request->isAjax)
		{
			return Yii::$app->view->renderFile('@app/modules/action/views/_loop.php', ['actions' => $actions]);
        } 
		else 
		{
			return $this->render('/actions', ['dataProvider' => $dataProvider, 'actions' => $actions, 'mainAction' => $mainAction]);
        }
    }
	
	protected function processPageRequest($param = 'page')
    {
        if (Yii::$app->request->isAjax && isset($_POST[$param]))
		{
			$_GET[$param] = Yii::$app->request->post($param);
		}
    }
}