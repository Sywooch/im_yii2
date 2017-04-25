<?php
namespace pistol88\cart\widgets; 
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
class TruncateButton extends \yii\base\Widget
{
    public $text = NULL;
    public $cssClass = 'btn btn-danger';
	public $lineSelector = 'ul';  //Селектор материнского элемента, где выводится элемент
    public $truncateCartUrl = '/cart/default/truncate';
 
    public function init()
    {
        parent::init();
        \pistol88\cart\assets\WidgetAsset::register($this->getView());
        if ($this->text == NULL) {
            $this->text = yii::t('cart', 'Truncate');
        }
        
        return true;
    }
    public function run()
    {
        return Html::a(Html::encode($this->text), [$this->truncateCartUrl],
            [
                'class' => 'pistol88-cart-truncate-button ' . $this->cssClass,
                'data-role' => 'truncate-cart-button',
				'data-line-selector' => $this->lineSelector,
                'data-url' => Url::toRoute($this->truncateCartUrl),
            ]);
    }
}