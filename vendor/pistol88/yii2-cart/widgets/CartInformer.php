<?php
namespace pistol88\cart\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
class CartInformer extends \yii\base\Widget
{
    public $text = NULL;
    public $offerUrl = NULL;
    public $cssClass = NULL;
    public $htmlTag = 'span';
	public $showOldPrice = true;
    public function init()
    {
        parent::init();
        \pistol88\cart\assets\WidgetAsset::register($this->getView());
        if ($this->offerUrl == NULL) {
            $this->offerUrl = Url::toRoute(["/cart/default/index"]);
        }
        
        if ($this->text === NULL) {
            $this->text = '{c} '. Yii::t('cart', 'on').' {p}';
        }
        
        return true;
    }
    public function run()
    {
        $cart = yii::$app->cart;
        if($this->showOldPrice == false | $cart->cost == $cart->getCost(false)) {
            $this->text = str_replace(['{c}', '{p}'],
                ['<span class="pistol88-cart-count">'.$cart->getCount().'</span>', '<strong class="pistol88-cart-price">'.$cart->getCostFormatted().'</strong>'],
                $this->text
            );
        } else {
            $this->text = str_replace(['{c}', '{p}'],
                ['<span class="pistol88-cart-count">'.$cart->getCount().'</span>', '<strong class="pistol88-cart-price"><s>'.round($cart->getCost(false)).'</s>'.$cart->getCostFormatted().'</strong>'],
                $this->text
            );
        }
        
        return Html::tag($this->htmlTag, $this->text, [
                'href' => $this->offerUrl,
                'class' => "pistol88-cart-informer {$this->cssClass}",
        ]);
    }
}
