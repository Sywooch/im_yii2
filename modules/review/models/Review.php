<?php

namespace app\modules\review\models;

use Yii;
use app\components\helpers\Text;

/********** USE MODELS *********/
use app\modules\seo\models\Seo;
use app\modules\file\models\File;

use app\modules\review\Module;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property string $id
 * @property string $title
 * @property string $client_id
 * @property string $teaser
 * @property string $body
 * @property string $alias
 * @property string $weight
 * @property integer $status
 */
class Review extends \yii\db\ActiveRecord
{
	public $imageFile;

    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * SEO
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['content_id' => 'id'])
            ->where(['module' => 'review']);
    }

    /**
     * THUMBNAIL IMAGE
     */
	public function getThumb($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'review']);
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['teaser', 'body', 'alias'], 'string'],
			[['client_id'], 'safe'],
            [['weight', 'status'], 'integer'],
			[['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
            [['title'], 'string', 'max' => 255],
			[['weight'], 'default', 'value' => 0],
			[['alias'], 'unique', 'message' => 'Значение должно быть уникальным! Материал с таким адресом уже существует на сайте.'],
			[['alias'], 'default', 'value' => function ($model, $attribute) {
				$default_alias = Text::transliterate($model->title);
				if(Review::find()->where(['alias' => $default_alias])->one()){
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
            'id' => Module::t('module', 'REVIEW_BACK_FORM_ID'),
			'title' => Module::t('module', 'REVIEW_BACK_FORM_TITLE'),
			'client_id' => Module::t('module', 'REVIEW_BACK_FORM_CLIENT'),
			'imageFile' => Module::t('module', 'REVIEW_BACK_FORM_FILE'),
            'teaser' => Module::t('module', 'REVIEW_BACK_FORM_TEASER'),
            'body' => Module::t('module', 'REVIEW_BACK_FORM_BODY'),
            'alias' => Module::t('module', 'REVIEW_BACK_FORM_ALIAS'),
            'weight' => Module::t('module', 'REVIEW_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'REVIEW_BACK_FORM_STATUS'),
        ];
    }
}