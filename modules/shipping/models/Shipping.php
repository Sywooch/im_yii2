<?php

namespace app\modules\shipping\models;

use Yii;
use app\modules\shipping\Module;
use app\modules\file\models\File;

/**
 * This is the model class for table "{{%shipping}}".
 *
 * @property string $id
 * @property string $title
 * @property string $body
 * @property string $action
 * @property string $price
 * @property integer $weight
 * @property integer $status
 */
class Shipping extends \yii\db\ActiveRecord
{
	public $imageFile;
	
	/**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%shipping}}';
    }
	
	/**
     * THUMBNAIL IMAGE
     */
	public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'shipping']);
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['body', 'action', 'price'], 'string'],
            [['weight', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
			[['weight'], 'default', 'value' => 0],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
        ];
    }
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'SHIPPING_BACK_FORM_ID'),
			'title' => Module::t('module', 'SHIPPING_BACK_FORM_TITLE'),
            'body' => Module::t('module', 'SHIPPING_BACK_FORM_BODY'),
			'imageFile' => Module::t('module', 'SHIPPING_BACK_FORM_ICON'),
            'action' => Module::t('module', 'SHIPPING_BACK_FORM_ACTION'),
			'price' => Module::t('module', 'SHIPPING_BACK_FORM_PRICE'),
            'weight' => Module::t('module', 'SHIPPING_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'SHIPPING_BACK_FORM_STATUS'),
        ];
    }
}