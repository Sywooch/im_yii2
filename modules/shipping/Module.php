<?php
namespace app\modules\shipping;
use Yii;
/**
 * shipping module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'shipping';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\shipping\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		
        // custom initialization code goes here
		Yii::$app->i18n->translations['modules/shipping/*'] = 
        [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/shipping/messages',
            'fileMap' => [
                'modules/shipping/module' => 'module.php',
            ],
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/shipping/' . $category, $message, $params, $language);
    }
}