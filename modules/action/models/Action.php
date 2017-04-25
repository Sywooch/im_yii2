<?php

namespace app\modules\action\models;

use Yii;
use app\components\helpers\Text;

/********** USE MODELS *********/
use app\modules\product\models\Product;
use app\modules\file\models\File;
use app\modules\seo\models\Seo;

use app\modules\action\Module;

/**
 * This is the model class for table "{{%action}}".
 *
 * @property string $id
 * @property string $title
 * @property string $short_title
 * @property string $date
 * @property string $teaser
 * @property string $body
 * @property string $alias
 * @property string $weight
 * @property integer $status
 * @property integer $is_main
 */
class Action extends \yii\db\ActiveRecord
{
	public $imageFile;
	public $imageGallery;

    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%action}}';
    }

    /**
     * SEO
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['content_id' => 'id'])
            ->where(['module' => 'action']);
    }

    /**
     * THUMBNAIL IMAGE
     */
    public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
            ->where(['type' => $type, 'module' => 'action']);
    }

    /**
     * PHOTO GALLERY
     */
	public function getFiles($type = 2)
    {
        return $this->hasMany(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'action'])
            ->orderBy('delta');
    }
	
	/**
     * PRODUCTS(PRODUCT_ACTION)
     */
	public function getAttachProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'child_id'])
            ->viaTable('product_action', ['parent_id' => 'id']);
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['short_title', 'status'], 'required'],
            [['teaser', 'short_title', 'body', 'alias', 'date'], 'string'],
            [['weight', 'status', 'is_main'], 'integer'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
			[['imageGallery'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2, 'maxFiles' => 100],
            [['title', 'short_title'], 'string', 'max' => 255],
			[['title'], 'default', 'value' => function ($model, $attribute) {
				return $model->short_title;
			}],
			[['weight'], 'default', 'value' => 0],
			[['is_main'], 'default', 'value' => 0],
			[['alias'], 'unique', 'message' => 'Значение должно быть уникальным! Материал с таким адресом уже существует на сайте.'],
			[['alias'], 'default', 'value' => function ($model, $attribute) {
				$default_alias = Text::transliterate($model->short_title);
				if(Action::find()->where(['alias' => $default_alias])->one()){
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
            'id' => Module::t('module', 'ACTION_BACK_FORM_ID'),
            'date' => Module::t('module', 'ACTION_BACK_FORM_DATE'),
			'title' => Module::t('module', 'ACTION_BACK_FORM_TITLE'),
			'short_title' => Module::t('module', 'ACTION_BACK_FORM_SHORT_TITLE'),
			'imageFile' => Module::t('module', 'ACTION_BACK_FORM_FILE'),
            'teaser' => Module::t('module', 'ACTION_BACK_FORM_TEASER'),
            'body' => Module::t('module', 'ACTION_BACK_FORM_BODY'),
            'alias' => Module::t('module', 'ACTION_BACK_FORM_ALIAS'),
            'weight' => Module::t('module', 'ACTION_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'ACTION_BACK_FORM_STATUS'),
        ];
    }
}