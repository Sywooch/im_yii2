<?php
namespace app\modules\main\models;
/********** USE MODELS *********/
use app\modules\seo\models\Seo;
use app\modules\file\models\File;
use app\modules\main\models\Setting;
use Yii;
use app\modules\main\Module;
/**
 * This is the model class for table "{{%siteinfo}}".
 *
 * @property string $id
 * @property string $title
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $slogan
 * @property string $body
 * @property string $map
 * @property string $counter
 * @property string $copyright
 */
class Siteinfo extends \yii\db\ActiveRecord
{
    public $logoFile;
    public $iconFile;
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%siteinfo}}';
    }
	
	/**
     * SETTING
     */
    public function getSetting()
    {
        return Setting::find()
			->where(['module' => 'main'])
			->all();
    }
    /**
     * SEO
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::className(), ['content_id' => 'id'])
            ->where(['module' => 'main']);
    }
    /**
     * LOGO IMAGE
     */
    public function getLogo($type = 1)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
            ->where(['type' => $type, 'module' => 'main']);
    }
    /**
     * FAVICON IMAGE
     */
    public function getIcon($type = 3)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
            ->where(['type' => $type, 'module' => 'main']);
    }
    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['title', 'email'], 'required'],
            [['address', 'body', 'map', 'counter'], 'string', 'max' => 100000],
            [['title', 'email', 'phone', 'slogan', 'copyright'], 'string', 'max' => 255],
            [['logoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => (1024*1024)*2],
            [['iconFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['ico'], 'maxSize' => 1024*1024],
        ];
    }
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'SI_BACK_FORM_ID'),
            'title' => Module::t('module', 'SI_BACK_FORM_TITLE'),
            'email' => Module::t('module', 'SI_BACK_FORM_EMAIL'),
            'phone' => Module::t('module', 'SI_BACK_FORM_PHONE'),
            'address' => Module::t('module', 'SI_BACK_FORM_ADDRESS'),
            'slogan' => Module::t('module', 'SI_BACK_FORM_SLOGAN'),
            'body' => Module::t('module', 'SI_BACK_FORM_BODY'),
            'map' => Module::t('module', 'SI_BACK_FORM_MAP'),
            'counter' => Module::t('module', 'SI_BACK_FORM_COUNTER'),
            'copyright' => Module::t('module', 'SI_BACK_FORM_COPYRIGHT'),
            'logoFile' => Module::t('module', 'SI_BACK_FORM_LOGO'),
            'iconFile' => Module::t('module', 'SI_BACK_FORM_ICON'),
        ];
    }
}