<?php

namespace app\modules\emailtemp\models;

use yii\helpers\ArrayHelper;
use app\modules\emailtemp\Module;
use app\components\helpers\Text;

use Yii;

/**
 * This is the model class for table "{{%emailtemp}}".
 *
 * @property string $id
 * @property string $title
 * @property string $subject
 * @property string $body
 * @property string $act
 */
class Emailtemp extends \yii\db\ActiveRecord
{
    public $post;

    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%emailtemp}}';
    }
	
	public function getActName()
    {
        return ArrayHelper::getValue(self::getActArray(), $this->act);
    }
 
    public static function getActArray()
    {
        return [
            1 => 'Регистрация шаг1',
			//2 => '',
			//3 => '',
            4 => 'Регистрация шаг2',
			//5 => '',
			//6 => '',
			7 => 'Восстановление пароля',
			8 => 'Изменение пароля',
			//9 => '',
            10 => 'Форма Заказ обратного звонка',
			//11 => '',
			//12 => '',
			13 => 'Форма боковая админу',
			14 => 'Форма боковая клиенту',
			//15 => '',
			16 => 'Форма Заказ услуги админу',
			17 => 'Форма Заказ услуги клиенту',
			
			18 => 'Форма Запись на событие клиенту',
			19 => 'Форма Запись на событие админу',
			
			20 => 'Форма Запись на акцию админу',
			21 => 'Форма Запись на акцию клиенту',
			
			22 => 'Форма Запись к специалисту админу',
			23 => 'Форма Запись к специалисту клиенту',
			//24 => '',
			25 => 'Форма Заказ сертификата админу',
			26 => 'Форма Заказ сертификата клиенту',
			//27 => '',
			28 => 'Форма Заказ товара админу',
			//29 => '',
			//30 => '',
			31 => 'Форма Заказ товара клиенту',
			//32 => '',
			//33 => '',
			34 => 'Форма Заказ тренинга админу',
			//35 => '',
			//36 => '',
			37 => 'Форма Заказ тренинга клиенту',
			//38 => '',
			//39 => '',
			//40 => '',
			//41 => '',
			//42 => '',
			43 => 'Форма Обратная связь',
        ];
    }
	
	public static function getVarsArray()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
			'email' => 'E-mail (логин при восстановлении доступа)',
			'password' => 'Пароль (новый пароль при восстановлении доступа)',
            'time' => 'Удобное время',
			'text' => 'Комментарий',
			'order' => 'Заказ (товар или тренинг)',
			'link' => 'Ссылка на подтверждение регистрации или на восстановление пароля',
			'target' => 'Цель формы (например: запись к специалисту - "Иванову И.И." или событие - "ПервоКЛАССные каникулы «Умные движения»")',
			'sitename' => 'Название сайта',
			'date' => 'Текущая дата',
        ];
    }

    /**
     * RULES
     */
    public function rules()
    {
        $this->post = Yii::$app->request->post('Emailtemp');
        return [
            [['title', 'subject', 'body', 'act'], 'required'],
            [['body', 'subject'], 'string'],
            [['act'], 'integer'],
            [['title', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'EMLTMP_BACKEND_FORM_ID'),
            'title' => Module::t('module', 'EMLTMP_BACKEND_FORM_TITLE'),
            'body' => Module::t('module', 'EMLTMP_BACKEND_FORM_BODY'),
            'subject' => Module::t('module', 'EMLTMP_BACKEND_FORM_SUBJECT'),
            'act' => Module::t('module', 'EMLTMP_BACKEND_FORM_ACT'),
        ];
    }
}
