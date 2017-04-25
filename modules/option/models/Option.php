<?php

namespace app\modules\option\models;
use Yii;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\product\models\Product;
use app\modules\file\models\File;

use app\modules\option\Module;

/**
 * This is the model class for table "{{%option}}".
 *
 * @property int $id
 * @property int $option_type
 * @property int $content_id
 * @property string $module
 * @property string $name
 * @property string $code
 * @property string $price
 * @property int $weight
 */
class Option extends \yii\db\ActiveRecord
{
	public $imageFile;
	
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
       return '{{%option}}';
    }
	
	/**
     * THUMBNAIL IMAGE
     */
	public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'option']);
    }
	
	/**
     * PRODUCT
     */
	public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'content_id'])->inverseOf('options');
    }
	
	/********************* OPTION TYPES *************************/
	public static function getOptionTypesArray()
    {
        return [
            1 => 'Цвет',
            2 => 'Размер',
        ];
    }
	
	public static function getOptionTypeName($optionType = false)
    {
		if($optionType)
		{
			return ArrayHelper::getValue(self::getOptionTypesArray(), $optionType);
		}
		else
		{
			return null;
		}
    }
	
	public static function getOptionName($optionType = 0, $optionContentId = 0, $optionCode = '', $optionModule = 'product')
    {
		$optionItems = Option::find()->where(['option_type' => $optionType, 'module' => $optionModule, 'code' => $optionCode, 'content_id' => $optionContentId])->one();
		if($optionItems)
		{
			return $optionItems->name;
		}
		else
		{
			return null;
		}
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['name', 'code', 'module', 'content_id', 'option_type'], 'required'],
            [['content_id', 'option_type', 'weight'], 'integer'],
            [['name', 'code', 'module'], 'string', 'max' => 255],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
			[['price'], 'double'],
			[['price'], 'default', 'value' => 0],
			[['weight'], 'default', 'value' => 0],
        ];
    }
	
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'OPTION_BACK_FORM_NAME'),
            'code' => Module::t('module', 'OPTION_BACK_FORM_CODE'),
			'price' => Module::t('module', 'OPTION_BACK_FORM_PRICE'),
			'option_type' => Module::t('module', 'OPTION_BACK_FORM_TYPE'),
			'weight' => Module::t('module', 'OPTION_BACK_FORM_WEIGHT'),
        ];
    }
}