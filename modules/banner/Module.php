<?php
namespace app\modules\banner;
use Yii;
/**
 * page module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
	public $imagesDirectory = 'slider';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\banner\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/banner/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/banner/messages',
                'fileMap' => [
                    'modules/banner/module' => 'module.php',
                ],
            ];
    }
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/banner/' . $category, $message, $params, $language);
    }
}