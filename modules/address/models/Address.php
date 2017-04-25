<?php

namespace app\modules\address\models;
use Yii;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\file\models\File;
use app\modules\user\models\User;
use app\modules\address\Module;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $country
 * @property string $zone
 * @property string $city
 * @property string $address
 * @property string $postcode
 * @property string $postname
 * @property string $postlastname
 * @property string $postphathername
 * @property string $comment
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
       return '{{%address}}';
    }
	
	/**
     * USER
     */
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('addresses');
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['title', 'address'], 'required'],
            [['user_id'], 'integer'],
            [['postname', 'postlastname', 'postphathername', 'postcode', 'address', 'country', 'zone', 'city', 'title'], 'string', 'max' => 255],
			[['comment'], 'string'],
        ];
    }
	
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
			'title' => Module::t('module', 'ADDRESS_BACK_FORM_TITLE'),
			'country' => Module::t('module', 'ADDRESS_BACK_FORM_COUNTRY'),
			'zone' => Module::t('module', 'ADDRESS_BACK_FORM_ZONE'),
			'city' => Module::t('module', 'ADDRESS_BACK_FORM_CITY'),
			'address' => Module::t('module', 'ADDRESS_BACK_FORM_ADDRESS'),
			'postcode' => Module::t('module', 'ADDRESS_BACK_FORM_POSTCODE'),
			
            'postname' => Module::t('module', 'ADDRESS_BACK_FORM_POSTNAME'),
            'postlastname' => Module::t('module', 'ADDRESS_BACK_FORM_POSTLASTNAME'),
            'postphathername' => Module::t('module', 'ADDRESS_BACK_FORM_POSTPHATHERNAME'),
            'comment' => Module::t('module', 'ADDRESS_BACK_FORM_COMMENT'),
        ];
    }
}