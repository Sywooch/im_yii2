<?php
namespace app\modules\order\models;

use Yii;
use app\components\helpers\Text;
use app\modules\order\Module;
use yii\helpers\ArrayHelper;

/********** USE MODELS *********/
use app\modules\order\models\OrderProduct;
use app\modules\shipping\models\Shipping;
use app\modules\payment\models\Payment;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $date
 * @property string $status
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $shipping
 * @property string $payment
 * @property string $type
 * @property string $total
 * @property string $text
 */
class Order extends \yii\db\ActiveRecord
{
	public $post;
	
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%order}}';
    }
	
	/********************* ORDER TYPE *************************/
	public static function getTypeArray()
    {
        return [
            'product' => 'Товары',
        ];
    }
	
	public function getTypeName($type = false)
    {
		if($type === false)
		{
			return ArrayHelper::getValue(self::getTypeArray(), $this->type);
		}
		else
		{
			return ArrayHelper::getValue(self::getTypeArray(), $type);
		}
    }
	
	/********************* ORDER STATUS *************************/
	public static function getStatusArray()
    {
        return [
            0 => 'Принят',
            1 => 'Оплачен',
			2 => 'Отменен',
        ];
    }
	
	public function getStatusName($status = false)
    {
		if($status === false)
		{
			return ArrayHelper::getValue(self::getStatusArray(), $this->status);
		}
		else
		{
			return ArrayHelper::getValue(self::getStatusArray(), $status);
		}
    }
	
	/********************* ORDER SHIPPING *************************/
	public function getShippingName($shipping = false)
    {
		if($shipping === false)
		{
			$shipping = $this->shipping;
			
		}
		
		if($shippingMethod = Shipping::findOne($shipping))
		{
			return $shippingMethod->title;
		}
		else
		{
			return null;
		}
    }
	
	/********************* ORDER PAYMENT *************************/
	public function getPaymentName($payment = false)
    {
		if($payment === false)
		{
			$payment = $this->payment;
			
		}
		
		if($paymentMethod = Payment::findOne($payment))
		{
			return $paymentMethod->title;
		}
		else
		{
			return null;
		}
    }
	
	/**
     * ORDER_PRODUCTS
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }
    /**
     * RULES
     */
    public function rules()
    {
		$this->post = Yii::$app->request->post('Order');
        return [
            [['date'], 'required'],
			[['user_id', 'status', 'shipping', 'payment'], 'integer'],
            [['date', 'name', 'phone', 'address', 'city', 'text', 'type'], 'string'],
			[['email'], 'email'],
            
			[['name', 'phone', 'email', 'address', 'city'], 'default', 'value' => ''],
			[['date'], 'default', 'value' => date('Y-m-d')],
			[['status'], 'default', 'value' => 0],
			[['shipping'], 'default', 'value' => 0],
			[['payment'], 'default', 'value' => 0],
			[['type'], 'default', 'value' => 'product'],
			[['user_id'], 'default', 'value' => 0],
        ];
    }
    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
			'id' => Module::t('module', 'ORDER_BACK_FORM_ID'),
			'user_id' => Module::t('module', 'ORDER_BACK_USER_ID'),
			'date' => Module::t('module', 'ORDER_BACK_DATE'),
			
			'name' => Module::t('module', 'ORDER_BACK_FORM_NAME'),
			'phone' => Module::t('module', 'ORDER_BACK_FORM_PHONE'),
            'email' => Module::t('module', 'ORDER_BACK_FORM_EMAIL'),
            'address' => Module::t('module', 'ORDER_BACK_FORM_ADDRESS'),
            'city' => Module::t('module', 'ORDER_BACK_FORM_CITY'),
			
            'shipping' => Module::t('module', 'ORDER_BACK_FORM_SHIPPING'),
            'payment' => Module::t('module', 'ORDER_BACK_FORM_PAYMENT'),
			'status' => Module::t('module', 'ORDER_BACK_FORM_STATUS'),
			
			'type' => Module::t('module', 'ORDER_BACK_FORM_TYPE'),
			'total' => Module::t('module', 'ORDER_BACK_FORM_TOTAL'),
			'text' => Module::t('module', 'ORDER_BACK_FORM_TEXT'),
        ];
    }
}