<?php

namespace app\modules\infoblock\models;

use app\modules\infoblock\Module;
use app\components\helpers\Text;

use Yii;

/**
 * This is the model class for table "{{%infoblock}}".
 *
 * @property string $id
 * @property string $title
 * @property string $body
 * @property string $alias
 * @property string $weight
 * @property integer $status
 */
class Infoblock extends \yii\db\ActiveRecord
{
    public $post;

    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%infoblock}}';
    }

    /**
     * RULES
     */
    public function rules()
    {
        $this->post = Yii::$app->request->post('Infoblock');
        return [
            [['title'], 'required'],
            [['body', 'alias'], 'string'],
            [['weight', 'status'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['alias'], 'default', 'value' => Text::transliterate($this->post['title'])],
            [['body'], 'default', 'value' => $this->post['title']],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'IBLOCK_BACKEND_FORM_ID'),
            'title' => Module::t('module', 'IBLOCK_BACKEND_FORM_TITLE'),
            'body' => Module::t('module', 'IBLOCK_BACKEND_FORM_BODY'),
            'alias' => Module::t('module', 'IBLOCK_BACKEND_FORM_ALIAS'),
            'weight' => Module::t('module', 'IBLOCK_BACKEND_FORM_WEIGHT'),
            'status' => Module::t('module', 'IBLOCK_BACKEND_FORM_STATUS'),
        ];
    }
}
