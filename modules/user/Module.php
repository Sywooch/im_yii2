<?php

namespace app\modules\user;

use Yii;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * директория картинок модуля (по умолчанию название модуля)
     */
    public $imagesDirectory = 'user';

    /**
     * роль по умолчанию
     */
    public $defaultRole = 'user';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		
		// подключаем модуль profile для того, чтобы работала локализаци€ из модуля profile в этом модуле
		Yii::$app->getModule('profile');
		Yii::$app->getModule('address');
		Yii::$app->getModule('company');

        // custom initialization code goes here
        Yii::$app->i18n->translations['modules/user/*'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'forceTranslation' => true,
                'basePath' => '@app/modules/user/messages',
                'fileMap' => [
                    'modules/user/module' => 'module.php',
                ],
            ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/user/' . $category, $message, $params, $language);
    }
}
