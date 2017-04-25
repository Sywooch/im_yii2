<?php
namespace app\modules\fav\widgets; 
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
class TruncateButton extends \yii\base\Widget
{
    public $text = NULL;
    public $cssClass = 'btn btn-danger';
	public $lineSelector = 'ul';  //Селектор материнского элемента, где выводится элемент
    public $truncateFavUrl = '/fav/default/truncate';
 
    public function init()
    {
        parent::init();
        \app\modules\fav\assets\WidgetAsset::register($this->getView());
        if ($this->text == NULL) {
            $this->text = yii::t('fav', 'Truncate');
        }
        
        return true;
    }
    public function run()
    {
        return Html::a(Html::encode($this->text), [$this->truncateFavUrl],
            [
                'class' => 'fav-truncate-button ' . $this->cssClass,
                'data-role' => 'truncate-fav-button',
				'data-line-selector' => $this->lineSelector,
                'data-url' => Url::toRoute($this->truncateFavUrl),
            ]);
    }
}