<?php

namespace app\modules\order;

use Yii;

/**
 * order module definition class
 */
class Module extends \yii\base\Module
{
	/**
     * Директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'order';
	
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\order\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/order/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/order/messages',
                'fileMap' => [
                    'modules/order/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/order/' . $category, $message, $params, $language);
    }
}