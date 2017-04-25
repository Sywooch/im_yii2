<?php

namespace app\modules\search;
use Yii;

/**
 * search module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'search';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\search\controllers';
	
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		
		// подключаем модуль catalog для того, чтобы работала локализация из модуля search в этом модуле
		Yii::$app->getModule('catalog');
		Yii::$app->getModule('article');
		Yii::$app->getModule('action');
		Yii::$app->getModule('page');
		Yii::$app->getModule('product');
		
        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/search/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/search/messages',
                'fileMap' => [
                    'modules/search/module' => 'module.php',
                ],
            ];
    }
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/search/' . $category, $message, $params, $language);
    }
}