<?php

namespace app\modules\catalog\models;

use Yii;
use app\components\helpers\Text;
use app\modules\catalog\Module;

/********** USE MODELS *********/
use app\modules\product\models\Product;
use app\modules\seo\models\Seo;
use app\modules\file\models\File;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $short_title
 * @property string $title
 * @property string $teaser
 * @property string $body
 * @property string $text1
 * @property string $text2
 * @property string $alias
 * @property string $weight
 * @property string $in_front
 * @property string $is_main
 * @property integer $status
 */
class Catalog extends \yii\db\ActiveRecord
{
	public $level = 0; // Коэфицент вложенности
	public $imageFile;
	public $imageGallery;
	
	private $_catalogArray;
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%catalog}}';
    }
    /**
     * SEO
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['content_id' => 'id'])
            ->where(['module' => 'catalog']);
    }
	
	/**
     * CHILDREN Дочерние материалы
     */
	public function getChildren()
    {
        return $this->hasMany(Catalog::className(), ['id' => 'parent_id'])
            ->viaTable('catalog_catalog', ['child_id' => 'id']);
    }
	
	/**
     * PARENT Родительский материал
     */
	public function getParent()
    {
		return $this->hasMany(Catalog::className(), ['id' => 'child_id'])
            ->viaTable('catalog_catalog', ['parent_id' => 'id']);
    }
	
	/**
     * UPDATE CHILDREN
     */
    private function updateChildrens()
    {
        $currentCatalogIds = $this->getChildren()->select('id')->column();
        $newCatalogIds = $this->getCatalogArray();
        foreach (array_filter(array_diff($newCatalogIds, $currentCatalogIds)) as $catalogId) {
            /** @var Catalog $catalog */
            if ($catalog = Catalog::findOne($catalogId)) {
                $this->link('children', $catalog);
            }
        }
        foreach (array_filter(array_diff($currentCatalogIds, $newCatalogIds)) as $catalogId) {
            /** @var Catalog $catalog */
            if ($catalog = Catalog::findOne($catalogId)) {
                $this->unlink('children', $catalog, true);
            }
        }
    }
	
	public function getCatalogArray()
    {
        if ($this->_catalogArray === null) {
            $this->_catalogArray = $this->getChildren()->select('id')->column();
        }
        return $this->_catalogArray;
    }
	
	public function setCatalogArray($value)
    {
        $this->_catalogArray = (array)$value;
    }
	
	/**
     * PRODUCTS(PRODUCT_SERVICE)
     */
	public function getAttachProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'child_id'])
            ->viaTable('product_catalog', ['parent_id' => 'id']);
    }
	
    /**
     * GALLERY
     */
	public function getFiles($type = 2)
    {
        return $this->hasMany(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'catalog'])
            ->orderBy('delta');
    }
	
    /**
     * THUMBNAIL1 IMAGE
     */
	public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'catalog']);
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['short_title', 'status'], 'required'],
            [['title', 'teaser', 'body', 'alias', 'text1'], 'string'],
            [['weight', 'status', 'parent_id', 'in_front', 'is_main'], 'integer'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
			
			[['catalogArray', 'attach'], 'safe'],
			
			[['weight'], 'default', 'value' => 0],
			[['parent_id'], 'default', 'value' => 0],
			[['in_front'], 'default', 'value' => 0],
			[['is_main'], 'default', 'value' => 0],
			[['title'], 'default', 'value' => function ($model, $attribute) {
				return $model->short_title;
			}],
			[['alias'], 'unique', 'message' => 'Значение должно быть уникальным! Материал с таким адресом уже существует на сайте.'],
			[['alias'], 'default', 'value' => function ($model, $attribute) {
				$default_alias = Text::transliterate($model->short_title);
				if(Catalog::find()->where(['alias' => $default_alias])->one()){
					return $default_alias.'-'.time();
				}
				else
				{
					return $default_alias;
				}
			}],
        ];
    }
	
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'SERVICE_BACK_FORM_ID'),
			'parent_id' => Module::t('module', 'SERVICE_BACK_FORM_PARENTID'),
			'short_title' => Module::t('module', 'SERVICE_BACK_FORM_SHORT_TITLE'),
			'title' => Module::t('module', 'SERVICE_BACK_FORM_TITLE'),
			'imageFile' => Module::t('module', 'SERVICE_BACK_FORM_FILE'),
            'teaser' => Module::t('module', 'SERVICE_BACK_FORM_TEASER'),
            'body' => Module::t('module', 'SERVICE_BACK_FORM_BODY'),
			'text1' => Module::t('module', 'SERVICE_BACK_FORM_TEXT1'),
            'alias' => Module::t('module', 'SERVICE_BACK_FORM_ALIAS'),
            'weight' => Module::t('module', 'SERVICE_BACK_FORM_WEIGHT'),
			'in_front' => Module::t('module', 'SERVICE_BACK_FORM_IN_FRONT'),
            'status' => Module::t('module', 'SERVICE_BACK_FORM_STATUS'),
        ];
    }
	
	/**
     * AFTER SAVE
     */
	public function afterSave($insert, $changedAttributes)
    {
        $this->updateChildrens();
        parent::afterSave($insert, $changedAttributes);
    }
}