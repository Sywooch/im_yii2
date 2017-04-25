<?php

namespace app\modules\catalog\controllers;

use app\controllers\FrontendController;
use app\modules\catalog\models\Catalog;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use Yii;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends FrontendController
{
	/**
     * Renders the view for the module
     * @return string
     */
    public function actionView($cat = '', $alias = '')
    {
		$catalog = Catalog::find()->where(['status' => 1, 'alias' => $alias, 'is_main' => 0])->one();
		
		if ($catalog) {
			
            $this->view->title = $catalog->title;
			/******************** SEO ************************/
			if($catalog->seo && !empty($catalog->seo->meta_title))
			{
				$this->view->title = $catalog->seo->meta_title;
			} 
			else 
			{
				$this->view->title = $catalog->title;
			}
			
			if($catalog->seo && !empty($catalog->seo->title_h1))
			{
				$this->view->params['title_h1'] = $catalog->seo->title_h1;
			} 
			else 
			{
				$this->view->params['title_h1'] = $catalog->title;
			}
			
			if($catalog->seo && !empty($catalog->seo->meta_desc))
			{
				$this->view->params['meta_description'] = $catalog->seo->meta_desc;
			} 
			else 
			{
				$this->view->params['meta_description'] = $catalog->teaser;
			}
			
			if($catalog->seo && !empty($catalog->seo->meta_key))
			{
				$this->view->params['meta_keywords'] = $catalog->seo->meta_key;
			}
			/******************** /SEO ***********************/
			return $this->render('/one-catalog', ['catalog' => $catalog, 'cat' => $cat]);
        } else {
            throw new NotFoundHttpException('404 Страница не найдена.');
        }
    }
	
    /**
     * Renders the index for the module
     * @return string
     */
    public function actionIndex($cat1 = null, $cat2 = null, $cat3 = null, $cat4 = null)
    {
		$parent = 0;
		$cat = null;
		
		$catInfo1 = null;
		$catInfo2 = null;
		$catInfo3 = null;
		$catInfo4 = null;
		
		$catalogInfo = false;
		$currentParamUrl = 'cat';
		
		if($cat1) 
		{
			$cat = $cat1;
			if($catInfo1 = Catalog::find()->where(['alias' => $cat1])->one())
			{
				$currentParamUrl .= '/'.$catInfo1->alias;
			}
		}
		if($cat2) 
		{
			$cat = $cat2;
			if($catInfo2 = Catalog::find()->where(['alias' => $cat2])->one())
			{
				$currentParamUrl .= '/'.$catInfo2->alias;
			}
		}
		if($cat3) 
		{
			$cat = $cat3;
			if($catInfo3 = Catalog::find()->where(['alias' => $cat3])->one())
			{
				$currentParamUrl .= '/'.$catInfo3->alias;
			}
		}
		if($cat4) 
		{
			$cat = $cat4;
			if($catInfo4 = Catalog::find()->where(['alias' => $cat4])->one())
			{
				$currentParamUrl .= '/'.$catInfo4->alias;
			}
		}
		
		if($cat)
		{
			$catalogInfo = Catalog::find()->where(['alias' => $cat, 'is_main' => 0])->one();
			if($catalogInfo)
			{
				$search = '[ORDER_BUTTON]';
				$replace = '<a class="button" onclick="addOrderCatalog('.$catalogInfo->id.', \''.htmlspecialchars($catalogInfo->short_title).'\', \'\');">Записаться</a>';
				
				$catalogInfo->body = str_replace($search, $replace, $catalogInfo->body);
				
				$search2 = '[TRAINING_BUTTON]';
				$replace2 = '<a href="/training" class="button">Выбор тренингов<br>и программ по свойствам</a>';
			
				$catalogInfo->body = str_replace($search2, $replace2, $catalogInfo->body);
			
				$catalog = Catalog::find()->where(['status' => 1, 'is_main' => 0])->all();
				
				$parent = $catalogInfo->id;
				$this->view->title = $catalogInfo->title;
				/******************** SEO ************************/
				if($catalogInfo->seo && !empty($catalogInfo->seo->meta_title))
				{
					$this->view->title = $catalogInfo->seo->meta_title;
				}
				else 
				{
					$this->view->title = $catalogInfo->title;
				}
				
				if($catalogInfo->seo && !empty($catalogInfo->seo->title_h1))
				{
					$this->view->params['title_h1'] = $catalogInfo->seo->title_h1;
				} 
				else 
				{
					$this->view->params['title_h1'] = $catalogInfo->title;
				}
				
				if($catalogInfo->seo && !empty($catalogInfo->seo->meta_desc))
				{
					$this->view->params['meta_description'] = $catalogInfo->seo->meta_desc;
				}
				else
				{
					$this->view->params['meta_description'] = $catalogInfo->teaser;
				}
				
				if($catalogInfo->seo && !empty($catalogInfo->seo->meta_key))
				{
					$this->view->params['meta_keywords'] = $catalogInfo->seo->meta_key;
				}
				/******************** /SEO ***********************/
				return $this->render('/cat-catalog', [
					'catalog' => $catalog, 
					'parent' => $parent,
					'catInfo1' => $catInfo1,
					'catInfo2' => $catInfo2,
					'catInfo3' => $catInfo3,
					'catInfo4' => $catInfo4,
					'currentParamUrl' => $currentParamUrl,
					'catalogInfo' => $catalogInfo,
				]);
			}
			else 
			{
				throw new NotFoundHttpException('404 Страница не найдена.');
			}
		}
		else
		{
			$catalog = Catalog::find()->where(['status' => 1, 'is_main' => 0])->all();
			
			if($catalog)
			{
				$this->view->title = 'Каталог услуг';
				$this->view->params['title_h1'] = 'Каталог услуг';
				
				$mainCatalog = Catalog::find()->where(['is_main' => 1])->one();
		
				if ($mainCatalog) 
				{
					/******************** SEO ************************/
					if($mainCatalog->seo) {
						if (!empty($mainCatalog->seo->meta_title)) {
							$this->view->title = $mainCatalog->seo->meta_title;
						}
						if (!empty($mainCatalog->seo->title_h1)) {
							$this->view->params['title_h1'] = $mainCatalog->seo->title_h1;
						}
						if (!empty($mainCatalog->seo->meta_desc)) {
							$this->view->params['meta_description'] = $mainCatalog->seo->meta_desc;
						}
						if (!empty($mainCatalog->seo->meta_key)) {
							$this->view->params['meta_keywords'] = $mainCatalog->seo->meta_key;
						}
					}
					/******************** /SEO ***********************/
				} 

				return $this->render('/catalog', [
					'catalog' => $catalog, 
					'parent' => $parent,
					'catInfo1' => $catInfo1,
					'catInfo2' => $catInfo2,
					'catInfo3' => $catInfo3,
					'catInfo4' => $catInfo4,
					'currentParamUrl' => $currentParamUrl,
				]);
			}
			else 
			{
				throw new NotFoundHttpException('404 Страница не найдена.');
			}
		}
    }
}