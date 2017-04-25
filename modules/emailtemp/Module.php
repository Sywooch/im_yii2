<?php

namespace app\modules\emailtemp;

use Yii;

/**
 * emailtemp module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'emailtemp';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\emailtemp\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/emailtemp/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/emailtemp/messages',
                'fileMap' => [
                    'modules/emailtemp/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/emailtemp/' . $category, $message, $params, $language);
    }
}
