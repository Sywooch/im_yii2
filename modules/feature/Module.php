<?php

namespace app\modules\feature;
use Yii;

/**
 * feature module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'feature';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\feature\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/feature/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/feature/messages/',
                'fileMap' => [
                    'modules/feature/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/feature/' . $category, $message, $params, $language);
    }
}
