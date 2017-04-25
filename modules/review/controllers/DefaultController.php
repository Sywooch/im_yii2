<?php

namespace app\modules\review\controllers;

use app\controllers\FrontendController;
use app\modules\review\models\Review;

use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

use Yii;

/**
 * Default controller for the `review` module
 */
class DefaultController extends FrontendController
{
	/**
     * Renders the view for the module
     * @return string
     */
    public function actionView($alias = '')
    {
		$review = Review::find()->where(['status' => 1, 'alias' => $alias])->one();
		
		if ($review) {
		
            $this->view->title = $review->title;
			
			/******************** SEO ************************/
			if($review->seo)
			{
				if (!empty($review->seo->meta_title))
				{
					$this->view->title = $review->seo->meta_title;
				}

				if (!empty($review->seo->meta_desc))
				{
					$this->view->params['meta_description'] = $review->seo->meta_desc;
				}

				if (!empty($review->seo->meta_key))
				{
					$this->view->params['meta_keywords'] = $review->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
			
			return $this->render('/one-review', ['review' => $review]);
			
        } else {
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
	
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex()
    {
		$reviews = Review::find()->where(['status' => 1])->all();
		
		if ($reviews) {
		
            $this->view->title = 'Отзывы';
			
			/******************** SEO ************************/
			if($reviews[0]->seo)
			{
				if (!empty($reviews[0]->seo->meta_title))
				{
					$this->view->title = $reviews[0]->seo->meta_title;
				}

				if (!empty($reviews[0]->seo->meta_desc))
				{
					$this->view->params['meta_description'] = $reviews[0]->seo->meta_desc;
				}

				if (!empty($reviews[0]->seo->meta_key))
				{
					$this->view->params['meta_keywords'] = $reviews[0]->seo->meta_key;
				}
			}
			/******************** /SEO ***********************/
			
			return $this->render('/review', ['reviews' => $reviews]);
			
        } else {
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
}
