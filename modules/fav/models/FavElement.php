<?php
namespace app\modules\fav\models;

use app\modules\fav\models\Fav;
use app\modules\fav\events\FavElement as FavElementEvent;
use app\modules\fav\events\Fav as FavEvent;
use app\modules\fav\interfaces\Element;
use yii;

class FavElement extends \yii\db\ActiveRecord implements Element
{
    const EVENT_ELEMENT_UPDATE = 'element_count';
    const EVENT_ELEMENT_DELETE = 'element_delete';

    public function getId()
    {
        return $this->id;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getName()
    {
        return $this->getModel()->getFavName();
    }
    
    public function getItemId()
    {
        return $this->item_id;
    }

    public function getModel($withFavElementModel = true)
    {
        if(!$withFavElementModel) {
            return $this->model;
        }

        $model = '\\'.$this->model;
        if(is_string($this->model) && class_exists($this->model)) {
            $productModel = new $model();
            if ($productModel = $productModel::findOne($this->item_id)) {
                $model = $productModel;
            } else {
                yii::$app->fav->truncate();
                throw new \yii\base\Exception('Element model not found');
            }
        } else {
            throw new \yii\base\Exception('Unknow element model');
        }

        return $model;
    }
    
    public function getModelName()
    {
        return $this->model;
    }

    public function setItemId($itemId)
    {
        $this->item_id = $itemId;
    }

    public function setCount($count, $andSave = false)
    {
        $this->count = $count;

        if($andSave) {
            if ($this->save()) {
                $elementEvent = new FavEvent([
                    'fav' => yii::$app->fav->getElements(),
                    'cost' => yii::$app->fav->getCost(),
                    'count' => yii::$app->fav->getCount(),
                ]);

                $favComponent = yii::$app->fav;
                $favComponent->trigger($favComponent::EVENT_FAV_UPDATE, $elementEvent);
            }
        }
    }

    public function countIncrement($count)
    {
        $this->count = $this->count+$count;

        return $this->save();
    }

    public function getPrice($withTriggers = true)
    {
        $price = $this->price;

        $fav = yii::$app->fav;

        if($withTriggers) {
            $elementEvent = new FavElementEvent(['element' => $this, 'cost' => $price]);
            $fav->trigger($fav::EVENT_ELEMENT_PRICE, $elementEvent);
            $price = $elementEvent->cost;
        }

        $elementEvent = new FavElementEvent(['element' => $this, 'cost' => $price]);
        $fav->trigger($fav::EVENT_ELEMENT_ROUNDING, $elementEvent);
        $price = $elementEvent->cost;

        return $price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public static function tableName()
    {
        return '{{%fav_element}}';
    }

    public function getCost($withTriggers = true)
    {
        $cost = 0;
        $costProduct = $this->getPrice($withTriggers);
        $fav = \Yii::$app->fav;
        
        for($i = 0; $i < $this->count; $i++) {
            $currentCostProduct = $costProduct;
            if($withTriggers) {
                $elementEvent = new FavElementEvent(['element' => $this, 'cost' => $currentCostProduct]);
                $fav->trigger($fav::EVENT_ELEMENT_COST_CALCULATE, $elementEvent);
                $currentCostProduct = $elementEvent->cost;
            }
            $cost = $cost+$currentCostProduct;
        }
        
        if($withTriggers) {
            $elementEvent = new FavElementEvent(['element' => $this, 'cost' => $cost]);
            $fav->trigger($fav::EVENT_ELEMENT_COST, $elementEvent);
            $cost = $elementEvent->cost;
        }
	    
        return $cost;
    }

    public function getFav()
    {
        return $this->hasOne(Fav::className(), ['id' => 'fav_id']);
    }

    public function rules()
    {
        return [
            [['fav_id', 'model', 'item_id'], 'required'],
            [['model'], 'validateModel'],
            [['hash'], 'string'],
            [['price'], 'double'],
            [['item_id', 'count', 'parent_id'], 'integer'],
        ];
    }

    public function validateModel($attribute, $param)
    {
        $model = $this->model;
        if (class_exists($model)) {
            $elementModel = new $model();
            if (!$elementModel instanceof \app\modules\fav\interfaces\FavElement) {
                $this->addError($attribute, 'Model implement error');
            }
        } else {
            $this->addError($attribute, 'Model not exists');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => yii::t('fav', 'ID'),
            'parent_id' => yii::t('fav', 'Parent element'),
            'price' => yii::t('fav', 'Price'),
            'hash' => yii::t('fav', 'Hash'),
            'model' => yii::t('fav', 'Model name'),
            'fav_id' => yii::t('fav', 'Fav ID'),
            'item_id' => yii::t('fav', 'Item ID'),
            'count' => yii::t('fav', 'Count'),
        ];
    }

    public function beforeSave($insert)
    {
        $fav = yii::$app->fav;

        $fav->fav->updated_time = time();
        $fav->fav->save();

        $elementEvent = new FavElementEvent(['element' => $this]);

        $this->trigger(self::EVENT_ELEMENT_UPDATE, $elementEvent);

        if($elementEvent->stop) {
            return false;
        } else {
            return true;
        }
    }

    public function beforeDelete()
    {
        $elementEvent = new FavElementEvent(['element' => $this]);

        $this->trigger(self::EVENT_ELEMENT_DELETE, $elementEvent);

        if($elementEvent->stop) {
            return false;
        } else {
            return true;
        }
    }
}
