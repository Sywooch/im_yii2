<?php
namespace app\modules\fav;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use app\modules\fav\events\Fav as FavEvent;
use app\modules\fav\events\FavElement as FavElementEvent;
use app\modules\fav\events\FavGroupModels;
use yii;

class Fav extends Component
{
    const EVENT_FAV_INIT = 'fav_init';
    const EVENT_FAV_TRUNCATE = 'fav_truncate';
    const EVENT_FAV_COST = 'fav_cost';
    const EVENT_FAV_COUNT = 'fav_count';
    const EVENT_FAV_PUT = 'fav_put';
    const EVENT_FAV_UPDATE = 'fav_update';
    const EVENT_FAV_ROUNDING = 'fav_rounding';
    const EVENT_MODELS_ROUNDING = 'fav_models_rounding';
    const EVENT_ELEMENT_COST = 'element_cost';
    const EVENT_ELEMENT_PRICE = 'element_price';
    const EVENT_ELEMENT_ROUNDING = 'element_rounding';
    const EVENT_ELEMENT_COST_CALCULATE = 'element_cost_calculate';

    private $cost = 0;
    private $element = null;
    private $fav = null;

    public $currency = NULL;
    public $elementBehaviors = [];
    public $currencyPosition = 'after';
    public $priceFormat = [2, '.', ''];

    public function __construct(interfaces\Fav $Fav, interfaces\Element $Element, $config = [])
    {
        $this->fav = $Fav;
        $this->element = $Element;

        parent::__construct($config);
    }

    public function init()
    {
        $this->trigger(self::EVENT_FAV_INIT, new FavEvent(['fav' => $this->fav]));
        $this->update();

        return $this;
    }

    public function put(\app\modules\fav\interfaces\FavElement $model, $count = 1)
    {
        if (!$elementModel = $this->fav->getElement($model)) {
            $elementModel = new $this->element;
            $elementModel->setCount((int)$count);
            $elementModel->setPrice($model->getFavPrice());
            $elementModel->setItemId($model->getFavId());
            $elementModel->setModel(get_class($model));

            $elementEvent = new FavElementEvent(['element' => $elementModel]);
            $this->trigger(self::EVENT_FAV_PUT, $elementEvent);

            if(!$elementEvent->stop) {
                try {
                    $this->fav->put($elementModel);
                } catch (Exception $e) {
                    throw new \yii\base\Exception(current($e->getMessage()));
                }
            }
        } else {
            $elementModel->countIncrement($count);
        }


        // TODO DRY
        $this->update();
        $elementEvent = new FavEvent([
            'fav' => $this->getElements(),
            'cost' => $this->getCost(),
            'count' => $this->getCount(),
        ]);
        $this->trigger(self::EVENT_FAV_UPDATE, $elementEvent);

        return $elementModel;
    }

    public function putWithPrice(\app\modules\fav\interfaces\FavElement $model, $price = 0, $count = 1)
    {
        if (!$elementModel = $this->fav->getElement($model)) {
            $elementModel = $this->element;
            $elementModel->setCount((int)$count);
            $elementModel->setPrice($price);
            $elementModel->setItemId($model->getFavId());
            $elementModel->setModel(get_class($model));

            $elementEvent = new FavElementEvent(['element' => $elementModel]);
            $this->trigger(self::EVENT_FAV_PUT, $elementEvent);

            if(!$elementEvent->stop) {
                try {
                    $this->fav->put($elementModel);
                } catch (Exception $e) {
                    throw new \yii\base\Exception(current($e->getMessage()));
                }
            }
        } else {
            $elementModel->countIncrement($count);
        }

        // TODO DRY
        $this->update();
        $elementEvent = new FavEvent([
            'fav' => $this->getElements(),
            'cost' => $this->getCost(),
            'count' => $this->getCount(),
        ]);
        $this->trigger(self::EVENT_FAV_UPDATE, $elementEvent);


        return $elementModel;
    }

    public function getElements()
    {
        return $this->fav->elements;
    }

    public function getHash()
    {
        $elements = $this->elements;

        return md5(implode('-', ArrayHelper::map($elements, 'id', 'id')).implode('-', ArrayHelper::map($elements, 'count', 'count')));
    }

    public function getCount()
    {
        $count = $this->fav->getCount();

        $favEvent = new FavEvent(['fav' => $this->fav, 'count' => $count]);
        $this->trigger(self::EVENT_FAV_COUNT, $favEvent);
        $count = $favEvent->count;

        return $count;
    }

    public function getCost($withTriggers = true)
    {
        $elements = $this->fav->elements;

        $pricesByModels = [];

        foreach($elements as $element) {
            $price = $element->getCost($withTriggers);

            if (!isset($pricesByModels[$element->model])) {
                $pricesByModels[$element->model] = 0;
            }

            $pricesByModels[$element->model] += $price;
        }

        $cost = 0;

        foreach($pricesByModels as $model => $price) {
            $favGroupModels = new FavGroupModels(['fav' => $this->fav, 'cost' => $price, 'model' => $model]);
            $this->trigger(self::EVENT_MODELS_ROUNDING, $favGroupModels);
            $cost += $favGroupModels->cost;
        }

        $favEvent = new FavEvent(['fav' => $this->fav, 'cost' => $cost]);

        if($withTriggers) {
            $this->trigger(self::EVENT_FAV_COST, $favEvent);
            $this->trigger(self::EVENT_FAV_ROUNDING, $favEvent);
        }

        $cost = $favEvent->cost;

        $this->cost = $cost;

        return $this->cost;
    }

    public function getCostFormatted()
    {
        $price = number_format($this->getCost(), $this->priceFormat[0], $this->priceFormat[1], $this->priceFormat[2]);

        if ($this->currencyPosition == 'after') {
            return "<span>$price</span>{$this->currency}";
        } else {
            return "<span>{$this->currency}</span>$price";
        }
    }

    public function getElementsByModel(\app\modules\fav\interfaces\FavElement $model)
    {
        return $this->fav->getElementByModel($model);
    }

    public function getElementById($id)
    {
        return $this->fav->getElementById($id);
    }

    public function getFav()
    {
        return $this->fav;
    }

    public function truncate()
    {
        $this->trigger(self::EVENT_FAV_TRUNCATE, new FavEvent(['fav' => $this->fav]));
        $truncate = $this->fav->truncate();
        $this->update();

        return $truncate;
    }

    public function deleteElement($element)
    {
        if ($element->delete()) {

            // TODO DRY
            $this->update();
            $elementEvent = new FavEvent([
                'fav' => $this->getElements(),
                'cost' => $this->getCost(),
                'count' => $this->getCount(),
            ]);
            $this->trigger(self::EVENT_FAV_UPDATE, $elementEvent);

            return true;
        } else {
            return false;
        }
    }

    private function update()
    {
        $this->fav = $this->fav->my();
        $this->cost = $this->fav->getCost();

        return true;
    }
}
