<?php

namespace app\modules\menu;

use Yii;

/**
 * menu module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'menu';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\menu\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/menu/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/menu/messages',
                'fileMap' => [
                    'modules/menu/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/menu/' . $category, $message, $params, $language);
    }
}
