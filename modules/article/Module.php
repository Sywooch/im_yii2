<?php
namespace app\modules\article;

use Yii;
/**
 * article module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
	public $imagesDirectory = 'article';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\article\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

		// custom initialization code goes here
		Yii::$app->i18n->translations['modules/article/*'] = 
        [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/article/messages',
            'fileMap' => [
                'modules/article/module' => 'module.php',
            ],
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/article/' . $category, $message, $params, $language);
    }
}