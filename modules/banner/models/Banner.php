<?php

namespace app\modules\banner\models;

use Yii;
use app\components\helpers\Text;
use app\modules\banner\Module;

/********** USE MODELS *********/
use app\modules\file\models\File;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property string $id
 * @property string $cat_id
 * @property string $text_block1
 * @property string $text_block2
 * @property string $text_block3
 * @property string $weight
 * @property integer $status
 */
class Banner extends \yii\db\ActiveRecord
{
	public $imageFile;

    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * THUMBNAIL IMAGE
     */
    public function getThumb($type = 1)
    {
        return $this->hasMany(File::className(), ['content_id' => 'id'])
            ->where(['type' => $type, 'module' => 'banner'])
            ->one();
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['cat_id', 'weight', 'status'], 'integer'],
            [['text_block1', 'text_block2', 'text_block3'], 'string'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
			[['weight'], 'default', 'value' => 0],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'BANNER_BACK_FORM_ID'),
			'cat_id' => Module::t('module', 'BANNER_BACK_FORM_CAT_ID'),
			'text_block1' => Module::t('module', 'BANNER_BACK_FORM_TEXT1'),
			'text_block2' => Module::t('module', 'BANNER_BACK_FORM_TEXT2'),
			'text_block3' => Module::t('module', 'BANNER_BACK_FORM_TEXT3'),
			'imageFile' => Module::t('module', 'BANNER_BACK_FORM_FILE'),
            'weight' => Module::t('module', 'BANNER_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'BANNER_BACK_FORM_STATUS'),
        ];
    }
}