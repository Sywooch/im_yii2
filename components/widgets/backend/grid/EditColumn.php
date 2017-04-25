<?php
/**
 * Created by PhpStorm.
 * User: СТД
 * Date: 10.08.2016
 * Time: 17:51
 */
namespace app\components\widgets\backend\grid;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;
class EditColumn extends DataColumn
{
    public $style = '';
	public $marginLeft = 15; // "Сдвиг" px вложенных элементов
	public $level = false; // Активация "сдвига" в зависимости от уровня вложенности, по умолчанию не активно
    public $fieldType = 'text';
	
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
		
		if(isset($model->name) && stristr($model->name, 'password', true))
		{
			$this->fieldType = 'password';
		}
		
		if($this->level)
		{
			$html = Html::activeInput($this->fieldType, $model, $this->attribute, ['name' => 'multiedit['.$key.']['.$this->attribute.']', 'style' => 'margin-left:'.$this->marginLeft*$model->level.'px;', 'class' => 'form-control grid-input '.$this->style]);
		}
		else
		{
			$html = Html::activeInput($this->fieldType, $model, $this->attribute, ['name' => 'multiedit['.$key.']['.$this->attribute.']', 'class' => 'form-control grid-input '.$this->style]);
		}
		
		if($this->fieldType == 'password')
		{
			$this->fieldType = 'text';
		}
        return $value === null ? $this->grid->emptyCell : $html;
    }
}