<?php

namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

/***** MODELS ******/
use app\modules\main\models\Siteinfo;

class FrontendController extends Controller
{
	protected $siteinfo;
	protected $setting;
	protected $page_class = 'page-index';
	
	public function behaviors()
    {
		$this->siteinfo = Siteinfo::find()->one();
		$this->view->params['siteinfo'] = $this->siteinfo;
		$this->view->params['setting'] = [];
		
		if(isset($this->siteinfo->setting))
		{
			foreach($this->siteinfo->setting as $item)
			{
				$this->view->params['setting'][$item->name] = $item->value;
			}
		}
		
		$this->view->params['page_class'] = $this->page_class;
		
		/***************************** SEO ******************************/
        $this->view->params['meta_description'] = '';
        $this->view->params['meta_keywords'] = '';
		$this->view->params['title_h1'] = '';
        
		if($this->siteinfo->seo)
        {
            if (!empty($this->siteinfo->seo->meta_title))
            {
                $this->view->title = $this->siteinfo->seo->meta_title;
            }
            $this->view->params['meta_description'] = $this->siteinfo->seo->meta_desc;
            $this->view->params['meta_keywords'] = $this->siteinfo->seo->meta_key;
        }
		/***************************** /SEO *****************************/
		
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
 
    public function actions()
    {
        return [
			'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}