<?php

namespace app\modules\feature\models;
use Yii;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\product\models\Product;
use app\modules\feature\Module;

/**
 * This is the model class for table "{{%feature}}".
 *
 * @property int $id
 * @property int $content_id
 * @property string $module
 * @property string $name
 * @property string $value
 * @property int $in_filter
 * @property int $weight
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
       return '{{%feature}}';
    }
	
	/**
     * USER
     */
	public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'content_id'])->inverseOf('features');
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['name', 'value', 'module', 'content_id'], 'required'],
            [['content_id', 'in_filter', 'weight'], 'integer'],
            [['name', 'value', 'module'], 'string', 'max' => 255],
			[['weight'], 'default', 'value' => 0],
        ];
    }
	
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'FEATURE_BACK_FORM_NAME'),
            'value' => Module::t('module', 'FEATURE_BACK_FORM_VALUE'),
			'in_filter' => Module::t('module', 'FEATURE_BACK_FORM_INFILTER'),
			'weight' => Module::t('module', 'FEATURE_BACK_FORM_WEIGHT'),
        ];
    }
}