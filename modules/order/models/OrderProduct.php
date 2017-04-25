<?php

namespace app\modules\order\models;

use Yii;

use app\modules\order\Module;

/**
 * This is the model class for table "{{%orderProduct}}".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $product_title
 * @property string $product_code
 * @property string $product_option
 * @property string $product_price
 * @property string $product_qty
 * @property string $product_total
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%order_product}}';
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['order_id', 'product_title', 'product_price'], 'required'],
            [['order_id', 'product_qty', 'product_id'], 'integer'],
            [['product_title', 'product_code', 'product_option'], 'string'],
			[['product_price', 'product_total'], 'double'],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_ID'),
            'order_id' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_ORDER_ID'),
			'product_id' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_ID'),
            'product_title' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_TITLE'),
            'product_code' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_CODE'),
            'product_option' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_OPTION'),
            'product_price' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_PRICE'),
            'product_qty' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_QTY'),
			'product_total' => Module::t('module', 'ORDER_PRODUCT_BACK_FORM_PRODUCT_TOTAL'),
        ];
    }
}
