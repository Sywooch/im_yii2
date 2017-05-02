<?php

namespace app\modules\product\models;

use Yii;
use app\components\helpers\Text;
use app\modules\product\Module;

/********** USE MODELS *********/
use app\modules\catalog\models\Catalog;
use app\modules\seo\models\Seo;
use app\modules\file\models\File;
use app\modules\action\models\Action;
use app\modules\feature\models\Feature;
use app\modules\option\models\Option;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property string $id
 * @property string $title
 * @property string $sku
 * @property string $code
 * @property string $price
 * @property string $old_price
 * @property string $teaser
 * @property string $body
 * @property string $alias
 * @property string $attach_title
 * @property string $weight
 * @property string $in_front
 * @property string $is_not
 * @property string $is_sale
 * @property string $is_hit
 * @property string $is_new
 * @property string $is_main
 * @property integer $status
 */
class Product extends \yii\db\ActiveRecord implements \pistol88\cart\interfaces\CartElement, \app\modules\fav\interfaces\FavElement
{
	public $imageFile;
	public $imageGallery;
	
	private $_productsArray;
	private $_actionsArray;
	private $_catalogArray;
	
	/**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%product}}';
    }
	
	/**
     * IMPLEMENTS CART INTERFACE
     */
	public function getCartId()
    {
        return $this->id;
    }

    public function getCartThumb()
    {
		if($file = $this->getThumb()->one())
		{
			return $file->filename;
		}
		else
		{
			return false;
		}
    }
	
	public function getCartName()
    {
        return $this->title;
    }
	
	public function getCartCode()
    {
        return $this->code;
    }
	
	public function getCartSku()
    {
        return $this->sku;
    }
	
	public function getCartAlias()
    {
        return $this->alias;
    }

    public function getCartPrice()
    {
        return $this->price;
    }
	
	public function getCartOldPrice()
    {
        return $this->old_price;
    }

    //Опции продукта для выбора при добавлении в корзину
    public function getCartOptions()
    {
        /* return [
            '1' => [
                'name' => 'Цвет',
                'variants' => ['1' => 'Красный', '2' => 'Белый', '3' => 'Синий'],
            ],
            '2' => [
                'name' => 'Размер',
                'variants' => ['4' => 'XL', '5' => 'XS', '6' => 'XXL'],
            ]
        ]; */
		
		$type = [];
		$type_data = Option::getOptionTypesArray();
		
		foreach($type_data as $typeId => $typeName)
		{
			$optionData = Option::find()->where(['option_type' => $typeId, 'module' => Module::getInstance()->id, 'content_id' => $this->id])->orderBy('weight')->all();
			if ($optionData) 
			{
				$variants = [];
				foreach($optionData as $option)
				{
					$variants[$option->code] = $option->name;
				}
				$type[$typeId] = [
					'name' => $typeName,
					'variants' => $variants,
				];
			}
		}
        return $type;
    }
	
	/**
     * IMPLEMENTS FAV INTERFACE
     */
	public function getFavId()
    {
        return $this->id;
    }

    public function getFavThumb()
    {
		if($file = $this->getThumb()->one())
		{
			return $file->filename;
		}
		else
		{
			return false;
		}
    }
	
	public function getFavName()
    {
        return $this->title;
    }
	
	public function getFavCode()
    {
        return $this->code;
    }
	
	public function getFavSku()
    {
        return $this->sku;
    }
	
	public function getFavAlias()
    {
        return $this->alias;
    }

    public function getFavPrice()
    {
        return $this->price;
    }
	
	public function getFavOldPrice()
    {
        return $this->old_price;
    }
	
	/**
     * SEO
     */
	public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['content_id' => 'id'])
			->where(['module' => 'product']);
    }
	
	/**
     * PHOTO GALLERY
     */
	public function getFiles($type = 2)
    {
        return $this->hasMany(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'product'])
            ->orderBy('delta');
    }
	
	/**
     * THUMBNAIL IMAGE
     */
	public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'product']);
    }
	
	/**
     * FEATURES
     */
	public function getFeatures()
    {
        return $this->hasMany(Feature::className(), ['content_id' => 'id'])->inverseOf('product')
			->where(['module' => 'product']);
    }
	
	/**
     * OPTIONS
     */
	public function getOptions()
    {
        return $this->hasMany(Option::className(), ['content_id' => 'id'])->inverseOf('product')
			->where(['module' => 'product']);
    }
	
	/**
     * ACTIONS(PRODUCT_ACTION)
     */
	public function getActions()
    {
        return $this->hasMany(Action::className(), ['id' => 'parent_id'])
            ->viaTable('product_action', ['child_id' => 'id']);
    }
	
	/**
     * UPDATE ACTIONS
     */
	private function updateActions()
    {
        $currentActionIds = $this->getActions()->select('id')->column();
        $newActionIds = $this->getActionsArray();
        foreach (array_filter(array_diff($newActionIds, $currentActionIds)) as $actionId) {
            /** @var Action $action */
            if ($action = Action::findOne($actionId)) {
                $this->link('actions', $action);
            }
        }
        foreach (array_filter(array_diff($currentActionIds, $newActionIds)) as $actionId) {
            /** @var Action $action */
            if ($action = Action::findOne($actionId)) {
                $this->unlink('actions', $action, true);
            }
        }
    }
	
	public function getActionsArray()
    {
        if ($this->_actionsArray === null) {
            $this->_actionsArray = $this->getActions()->select('id')->column();
        }
        return $this->_actionsArray;
    }
	
	public function setActionsArray($value)
    {
        $this->_actionsArray = (array)$value;
    }
	
	/**
     * CATALOG(PRODUCT_CATALOG)
     */
	public function getCatalog()
    {
        return $this->hasMany(\app\modules\catalog\models\Catalog::className(), ['id' => 'parent_id'])
            ->viaTable('product_catalog', ['child_id' => 'id']);
    }
	
	/**
     * UPDATE CATALOG
     */
	private function updateCatalog()
    {
        $currentCatalogIds = $this->getCatalog()->select('id')->column();
        $newCatalogIds = $this->getCatalogArray();
		
        foreach (array_filter(array_diff($newCatalogIds, $currentCatalogIds)) as $catalogId) {
            /** @var Catalog $catalog */
            if ($catalog = Catalog::findOne($catalogId)) {
                $this->link('catalog', $catalog);
            }
        }
		
        foreach (array_filter(array_diff($currentCatalogIds, $newCatalogIds)) as $catalogId) {
            /** @var Catalog $catalog */
            if ($catalog = Catalog::findOne($catalogId)) {
                $this->unlink('catalog', $catalog, true);
            }
        }
    }
	
	public function getCatalogArray()
    {
        if ($this->_catalogArray === null) {
            $this->_catalogArray = $this->getCatalog()->select('id')->column();
        }
        return $this->_catalogArray;
    }
	
	public function setCatalogArray($value)
    {
        $this->_catalogArray = (array)$value;
    }
	
	/**
     * PRODUCTS(PRODUCT_PRODUCT)
     */
	public function getAttachProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'child_id'])
            ->viaTable('product_product', ['parent_id' => 'id']);
    }
	
	public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'parent_id'])
            ->viaTable('product_product', ['child_id' => 'id']);
    }
	
	/**
     * UPDATE PRODUCTS
     */
	private function updateProducts()
    {
        $currentProductIds = $this->getProducts()->select('id')->column();
        $newProductIds = $this->getProductsArray();
        foreach (array_filter(array_diff($newProductIds, $currentProductIds)) as $productId) {
            /** @var Product $product */
            if ($product = Product::findOne($productId)) {
                $this->link('products', $product);
            }
        }
        foreach (array_filter(array_diff($currentProductIds, $newProductIds)) as $productId) {
            /** @var Product $product */
            if ($product = Product::findOne($productId)) {
                $this->unlink('products', $product, true);
            }
        }
    }
	
	public function getProductsArray()
    {
        if ($this->_productsArray === null) {
            $this->_productsArray = $this->getProducts()->select('id')->column();
        }
        return $this->_productsArray;
    }
	
	public function setProductsArray($value)
    {
        $this->_productsArray = (array)$value;
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['title', 'code', 'status'], 'required'],
            [['teaser', 'body', 'alias', 'attach_title'], 'string'],
			[['price', 'old_price'], 'double'],
			
			[['productsArray', 'actionsArray', 'catalogArray'], 'safe'],
			
            [['weight', 'status', 'in_front', 'is_not', 'is_hit', 'is_new', 'is_sale', 'is_main'], 'integer'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
			[['imageGallery'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2, 'maxFiles' => 100],
            [['title', 'code', 'sku'], 'string', 'max' => 255],
			
			[['code'], 'unique', 'message' => 'Значение должно быть уникальным! Товар с таким кодом уже существует на сайте.'],
			[['sku'], 'unique', 'message' => 'Значение должно быть уникальным! Товар с таким артикулом уже существует на сайте.'],
			
			[['weight'], 'default', 'value' => 0],
			[['is_main'], 'default', 'value' => 0],
			[['is_hit'], 'default', 'value' => 0],
			[['is_sale'], 'default', 'value' => 0],
			[['is_new'], 'default', 'value' => 0],
			[['in_front'], 'default', 'value' => 0],
			
			[['attach_title'], 'default', 'value' => 'Возможно, вас также заинтересует'],
			
			[['alias'], 'unique', 'message' => 'Значение должно быть уникальным! Товар с таким адресом уже существует на сайте.'],
			[['alias'], 'default', 'value' => function ($model, $attribute) {
				$default_alias = Text::transliterate($model->title);
				if(Product::find()->where(['alias' => $default_alias])->one()){
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
            'id' => Module::t('module', 'PRODUCT_BACK_FORM_ID'),
			'title' => Module::t('module', 'PRODUCT_BACK_FORM_TITLE'),
			'code' => Module::t('module', 'PRODUCT_BACK_FORM_CODE'),
			'sku' => Module::t('module', 'PRODUCT_BACK_FORM_SKU'),
			'price' => Module::t('module', 'PRODUCT_BACK_FORM_PRICE'),
			'old_price' => Module::t('module', 'PRODUCT_BACK_FORM_OLD_PRICE'),
			
			'productsArray' => Module::t('module', 'PRODUCT_BACK_FORM_PR_ARRAY'),
			'actionsArray' => Module::t('module', 'PRODUCT_BACK_FORM_ACT_ARRAY'),
			'catalogArray' => Module::t('module', 'PRODUCT_BACK_FORM_SER_ARRAY'),
			
            'teaser' => Module::t('module', 'PRODUCT_BACK_FORM_TEASER'),
            'body' => Module::t('module', 'PRODUCT_BACK_FORM_BODY'),
            'alias' => Module::t('module', 'PRODUCT_BACK_FORM_ALIAS'),
			'attach_title' => Module::t('module', 'PRODUCT_BACK_FORM_ATTACH_TITLE'),
			
			'imageFile' => Module::t('module', 'PRODUCT_BACK_FORM_FILE'),
			
            'weight' => Module::t('module', 'PRODUCT_BACK_FORM_WEIGHT'),
			'in_front' => Module::t('module', 'PRODUCT_BACK_FORM_IN_FRONT'),
			'is_not' => Module::t('module', 'PRODUCT_BACK_FORM_IS_NOT'),
			'is_hit' => Module::t('module', 'PRODUCT_BACK_FORM_IS_HIT'),
			'is_sale' => Module::t('module', 'PRODUCT_BACK_FORM_IS_SALE'),
			'is_new' => Module::t('module', 'PRODUCT_BACK_FORM_IS_NEW'),
            'status' => Module::t('module', 'PRODUCT_BACK_FORM_STATUS'),
        ];
    }
	
	/**
     * AFTER SAVE
     */
	public function afterSave($insert, $changedAttributes)
    {
		$this->updateProducts();
		$this->updateActions();
		$this->updateCatalog();
		
        parent::afterSave($insert, $changedAttributes);
    }
}