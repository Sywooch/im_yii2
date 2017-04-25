<?php

namespace app\modules\fav\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii;

class FavInformer extends \yii\base\Widget
{
    public $text = NULL;
    public $offerUrl = NULL;
    public $cssClass = NULL;
    public $htmlTag = 'span';
	public $showOldPrice = true;
	
    public function init()
    {
        parent::init();
		
        \app\modules\fav\assets\WidgetAsset::register($this->getView());
        if ($this->offerUrl == NULL) {
            $this->offerUrl = Url::toRoute(["/fav/default/index"]);
        }
        
        if ($this->text === NULL) {
            $this->text = '{c} '. Yii::t('fav', 'on').' {p}';
        }
        
        return true;
    }
    public function run()
    {
        $fav = yii::$app->fav;
        if($this->showOldPrice == false | $fav->cost == $fav->getCost(false)) {
            $this->text = str_replace(['{c}', '{p}'],
                ['<span class="fav-count">'.$fav->getCount().'</span>', '<strong class="fav-price">'.$fav->getCostFormatted().'</strong>'],
                $this->text
            );
        } else {
            $this->text = str_replace(['{c}', '{p}'],
                ['<span class="fav-count">'.$fav->getCount().'</span>', '<strong class="fav-price"><s>'.round($fav->getCost(false)).'</s>'.$fav->getCostFormatted().'</strong>'],
                $this->text
            );
        }
        
        return Html::tag($this->htmlTag, $this->text, [
                'href' => $this->offerUrl,
                'class' => "fav-informer {$this->cssClass}",
        ]);
    }
}
