<?php

namespace app\modules\filter\models;

use Yii;
use app\modules\filter\Module;

/**
 * This is the model class for table "{{%filter}}".
 *
 * @property string $id
 * @property string $title
 * @property string $icon
 * @property string $weight
 * @property integer $status
 */
class Filter extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%filter}}';
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['weight', 'status'], 'integer'],
            [['title', 'icon'], 'string', 'max' => 255],
			[['weight'], 'default', 'value' => 0],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'FILTER_BACK_FORM_ID'),
			'title' => Module::t('module', 'FILTER_BACK_FORM_TITLE'),
			'icon' => Module::t('module', 'FILTER_BACK_FORM_ICON'),
            'weight' => Module::t('module', 'FILTER_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'FILTER_BACK_FORM_STATUS'),
        ];
    }
}
