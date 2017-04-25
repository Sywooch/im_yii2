<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use app\modules\file\components\Image;
use vova07\imperavi\actions\GetAction;

/***** MODELS ******/
use app\modules\main\models\Siteinfo;

class BackendController extends Controller
{
	protected $imagesPath;
	protected $imagesDownloadPath;
	protected $imagesVersion;
	
	protected $siteinfo;
	protected $setting;
	
	protected $post;
	
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
		
		$this->layout = '//admin';
		
		$this->imagesPath = Yii::$app->params['images']['paths']['uploadDir'];
		$this->imagesDownloadPath = Yii::$app->params['images']['paths']['downloadDir'];
		$this->imagesVersion = Yii::$app->params['images']['versions'];
		
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['adminPanel'], // Разрешен доступ для роли/правила "admin, user, adminPanel"
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
					'delete-image' => ['post'],
					'multi-delete' => ['post'],
                ],
            ],
        ];
    }
	
	/***************************** Загрузка, вывод картинок в редакторе **********************************/
	public function actions()
    {
        $id = 'all';
		$module = 'all';
		$imagesDirectory = '/files';
		
		$this->imagesPath = Yii::$app->params['images']['paths']['uploadDir'];
		$this->imagesDownloadPath = Yii::$app->params['images']['paths']['downloadDir'];
		
		if(Yii::$app->request->get('id')) $id = Yii::$app->request->get('id');
		if(Yii::$app->request->get('imagesDirectory')) $imagesDirectory = Yii::$app->request->get('imagesDirectory');
		
		return [
			'images-get' => [
				'class' => 'vova07\imperavi\actions\GetAction',
				'url' => $this->imagesDownloadPath.$imagesDirectory.'/'.$id.'/static/', // URL адрес папки где хранятся изображения.
				'path' => $this->imagesPath.$imagesDirectory.'/'.$id.'/static/', // Или абсолютный путь к папке с изображениями.
				'type' => GetAction::TYPE_IMAGES,
			],
			'image-upload' => [
				'class' => 'vova07\imperavi\actions\UploadAction',
				'url' => $this->imagesDownloadPath.$imagesDirectory.'/'.$id.'/static/', // URL адрес папки куда будут загружатся изображения.
				'path' => $this->imagesPath.$imagesDirectory.'/'.$id.'/static/', // Или абсолютный путь к папке куда будут загружатся изображения.
				'unique' => false, // Если true названия файлов переименовываются в уникальные значения
			],
			'files-get' => [
				'class' => 'vova07\imperavi\actions\GetAction',
				'url' => $this->imagesDownloadPath.$imagesDirectory.'/'.$id.'/static/files/', // URL адрес папки где хранятся файлы.
				'path' => $this->imagesPath.$imagesDirectory.'/'.$id.'/static/files/', // Или абсолютный путь к папке с файлами.
				'type' => GetAction::TYPE_FILES,
			],
			'file-upload' => [
				'class' => 'vova07\imperavi\actions\UploadAction',
				'url' => $this->imagesDownloadPath.$imagesDirectory.'/'.$id.'/static/files/', // URL адрес папки куда будут загружатся файлы.
				'path' => $this->imagesPath.$imagesDirectory.'/'.$id.'/static/files/', // Или абсолютный путь к папке куда будут загружатся файлы.
				'uploadOnlyImage' => false, // For not image-only uploading.
				'unique' => false, // Если true названия файлов переименовываются в уникальные значения
			],
		];
    }
	/***************************** /Загрузка, вывод картинок в редакторе **********************************/
	
	/***************************** Удаление картинок по AJAX **********************************/
	public function actionDeleteImage()
    {
        if (Image::deleteAsPost(Yii::$app->request->post()))
		{
			echo 'success';
        } 
		else 
		{
			echo 'error';
		}
    }
	/***************************** /Удаление картинок по AJAX **********************************/
}