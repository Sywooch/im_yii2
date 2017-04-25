<?php

namespace app\modules\profile\models;
use Yii;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\file\models\File;
use app\modules\user\models\User;
use app\modules\profile\Module;
/**
 * This is the model class for table "{{%profile}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $lastname
 * @property string $phathername
 * @property string $phone
 * @property string $email
 * @property string $age
 * @property string $sale
 * @property string $sub
 */
class Profile extends \yii\db\ActiveRecord
{
	public $imageGallery;
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
       return '{{%profile}}';
    }
	
	/**
     * USER
     */
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('profile');
    }
	
	/**
     * THUMBNAIL IMAGE
     */
	public function getThumb($type = 2)
    {
        return $this->hasOne(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'profile']);
    }
	
	/**
     * PHOTO GALLERY
     */
	public function getFiles($type = 2)
    {
        return $this->hasMany(File::className(), ['content_id' => 'id'])
			->where(['type' => $type, 'module' => 'profile'])
            ->orderBy('delta');
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['name', 'phone'], 'required'],
            [['user_id', 'sub'], 'integer'],
            [['name', 'lastname', 'phathername', 'phone', 'email', 'sale'], 'string', 'max' => 255],
			[['email'], 'email'],
        ];
    }
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'PROFILE_BACK_FORM_NAME'),
            'lastname' => Module::t('module', 'PROFILE_BACK_FORM_LASTNAME'),
            'phathername' => Module::t('module', 'PROFILE_BACK_FORM_PHATHERNAME'),
            'phone' => Module::t('module', 'PROFILE_BACK_FORM_PHONE'),
			'email' => Module::t('module', 'PROFILE_BACK_FORM_EMAIL'),
            'age' => Module::t('module', 'PROFILE_BACK_FORM_AGE'),
			'sub' => Module::t('module', 'PROFILE_BACK_FORM_SUB'),
			'sale' => Module::t('module', 'PROFILE_BACK_FORM_SALE'),
			'imageGallery' => Module::t('module', 'PROFILE_BACK_FORM_GALLERY'),
        ];
    }
}