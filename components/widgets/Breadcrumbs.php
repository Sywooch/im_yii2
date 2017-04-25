<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Breadcrumbs extends Widget
{
    public $encodeLabels = true;
    public $homeLink;
    public $links = [];

    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ]);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink);
        }
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link);
        }
        echo Html::tag('div', implode('', $links), ['class' => 'bread']);
    }
	
    protected function renderItem($link)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
		
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
		
        if (isset($link['url'])) {
            $options = $link;
            unset($options['label'], $options['url']);
            $link = Html::a($label, $link['url'], ['class' => 'bread__a']);
        } else {
            $link = $label;
        }
        return $link;
    }
}
