<?php
namespace app\modules\fav\events;

use yii\base\Event;

class FavGroupModels extends Event
{
    public $cost;
    public $fav;
    public $model;
}