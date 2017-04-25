<?php
/**
 * Created by PhpStorm.
 * User: СТД
 * Date: 10.08.2016
 * Time: 23:08
 */

namespace app\components\widgets\backend\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;


class StatusColumn extends DataColumn
{
    public $fieldType = 'hidden';
    public $filter = [0 => 'Отключен', 1 => 'Активен'];

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $class = $value ? 'success on' : 'default off';
        $label = $value ? 'Активен' : 'Отключен';
        $title = $value ? 'Отключить' : 'Активировать';

        $span = Html::tag('span', Html::encode($label), ['class' => 'switcher label label-' . $class, 'title' => $title]);
        $field = Html::activeInput($this->fieldType, $model, $this->attribute, ['name' => 'multiedit['.$key.']['.$this->attribute.']']);

        $html = Html::tag('p', $span.$field, ['class' => 'text-right']);

        return $value === null ? $this->grid->emptyCell : $html;
    }
}