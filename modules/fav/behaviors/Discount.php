<?php
namespace app\modules\fav\behaviors;

use yii\base\Behavior;
use app\modules\fav\Fav;

class Discount extends Behavior
{
    public $percent = 0;

    public function events()
    {
        return [
            Fav::EVENT_FAV_COST => 'doDiscount'
        ];
    }

    public function doDiscount($event)
    {
        if($this->percent > 0 && $this->percent <= 100 && $event->cost > 0) {
            $event->cost = $event->cost-($event->cost*$this->percent)/100;
        }

        return $this;
    }
}
