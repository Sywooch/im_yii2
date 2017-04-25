<?php
namespace app\modules\fav\events;

use yii\base\Event;

class FavElement extends Event
{
    public $element;
    public $cost;
    public $stop;
}