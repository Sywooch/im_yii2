<?php

namespace app\modules\product;

use Yii;

/**
 * product module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * ���������� �������� ������ (�� ��������� �������� ������)
     */
    public $imagesDirectory = 'product';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\product\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		// ���������� ������ feature ��� ����, ����� �������� ���������� �� ������ feature � ���� ������
		Yii::$app->getModule('feature');
		Yii::$app->getModule('option');

        // custom initialization code goes here
		Yii::$app->i18n->translations['modules/product/*'] = 
        [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/product/messages',
            'fileMap' => [
                'modules/product/module' => 'module.php',
            ],
        ];
    }
	
	public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/product/' . $category, $message, $params, $language);
    }
}
