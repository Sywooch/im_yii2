<?php
namespace app\modules\fav\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
class FavButton extends \yii\base\Widget
{
    public $text = NULL;
    public $model = NULL;
    public $count = 1;
    public $price = false;
    public $description = '';
    public $cssClass = NULL;
    public $htmlTag = 'a';
    public $addElementUrl = '/fav/element/create';
    public function init()
    {
        parent::init();
        \app\modules\fav\assets\WidgetAsset::register($this->getView());

        if ($this->text === NULL) {
            $this->text = Yii::t('fav', 'Buy');
        }
        if ($this->cssClass === NULL) {
            $this->cssClass = 'btn btn-success';
        }
        
        return true;
    }
    public function run()
    {
        if (!is_object($this->model) | !$this->model instanceof \app\modules\fav\interfaces\FavElement) {
            return false;
        }
        $model = $this->model;
        return Html::tag($this->htmlTag, $this->text, [
            'href' => Url::toRoute($this->addElementUrl),
            'class' => "fav-buy-button fav-add-button{$this->model->getFavId()} {$this->cssClass}",
            'data-id' => $model->getFavId(),
            'data-url' => Url::toRoute($this->addElementUrl),
            'data-role' => 'fav-add-button',
            'data-count' => $this->count,
            'data-price' => (int)$this->price,
            'data-description' => $this->description,
            'data-model' => $model::className()
        ]);
    }
}