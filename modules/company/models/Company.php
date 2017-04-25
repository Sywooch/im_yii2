<?php

namespace app\modules\company\models;
use Yii;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\user\models\User;
use app\modules\company\Module;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $company
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $fax
 * @property string $comment
 * @property string $bankname
 * @property string $inn
 * @property string $bik
 * @property string $kpp
 * @property string $rs
 * @property string $ks
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
       return '{{%company}}';
    }
	
	/**
     * USER
     */
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('companies');
    }
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['company'], 'required'],
            [['user_id'], 'integer'],
            [['company', 'address', 'fax', 'phone', 'email', 'bankname', 'inn', 'bik', 'kpp', 'rs', 'ks'], 'string', 'max' => 255],
			[['comment'], 'string'],
			[['email'], 'email'],
        ];
    }
	
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'company' => Module::t('module', 'COMPANY_BACK_FORM_COMPANY'),
            'address' => Module::t('module', 'COMPANY_BACK_FORM_ADDRESS'),
            'fax' => Module::t('module', 'COMPANY_BACK_FORM_FAX'),
            'phone' => Module::t('module', 'COMPANY_BACK_FORM_PHONE'),
			'email' => Module::t('module', 'COMPANY_BACK_FORM_EMAIL'),
            'comment' => Module::t('module', 'COMPANY_BACK_FORM_COMMENT'),
			'bankname' => Module::t('module', 'COMPANY_BACK_FORM_BANKNAME'),
			'inn' => Module::t('module', 'COMPANY_BACK_FORM_INN'),
			'kpp' => Module::t('module', 'COMPANY_BACK_FORM_KPP'),
			'bik' => Module::t('module', 'COMPANY_BACK_FORM_BIK'),
			'rs' => Module::t('module', 'COMPANY_BACK_FORM_RS'),
			'ks' => Module::t('module', 'COMPANY_BACK_FORM_KS'),
        ];
    }
}