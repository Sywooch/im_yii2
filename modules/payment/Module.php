<?php
namespace app\modules\payment;
use Yii;
/**
 * payment module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'payment';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\payment\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		
        // custom initialization code goes here
		Yii::$app->i18n->translations['modules/payment/*'] = 
        [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/payment/messages',
            'fileMap' => [
                'modules/payment/module' => 'module.php',
            ],
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/payment/' . $category, $message, $params, $language);
    }
}