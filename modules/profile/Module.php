<?php

namespace app\modules\profile;
use Yii;

/**
 * profile module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'profile';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\profile\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/profile/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/profile/messages/',
                'fileMap' => [
                    'modules/profile/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/profile/' . $category, $message, $params, $language);
    }
}
