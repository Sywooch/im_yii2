<?php

namespace app\modules\catalog;

use Yii;

/**
 * catalog module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'catalog';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\catalog\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/catalog/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/catalog/messages',
                'fileMap' => [
                    'modules/catalog/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/catalog/' . $category, $message, $params, $language);
    }
}
