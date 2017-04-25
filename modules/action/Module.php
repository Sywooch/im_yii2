<?php
namespace app\modules\action;

use Yii;
/**
 * action module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
	public $imagesDirectory = 'action';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\action\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

		// custom initialization code goes here
		Yii::$app->i18n->translations['modules/action/*'] = 
        [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/action/messages',
            'fileMap' => [
                'modules/action/module' => 'module.php',
            ],
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/action/' . $category, $message, $params, $language);
    }
}