<?php
namespace app\modules\fav\events;

use yii\base\Event;

class Fav extends Event
{
    public $fav;
    public $cost;
    public $count;
}