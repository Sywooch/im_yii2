<?php

namespace app\modules\review;
use Yii;

/**
 * review module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'review';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\review\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/review/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/review/messages',
                'fileMap' => [
                    'modules/review/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/review/' . $category, $message, $params, $language);
    }
}
