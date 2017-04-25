<?php
namespace app\components\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;

class CatalogMenuTreeItems extends \app\components\widgets\Tree
{
    public $data = null;
	public $parentFieldValue = 0;
	public $nameField = 'title';
	public $url = '/';
	
	public $ulParentClass = null;
	public $ulChildClass = null;
	public $liParentClass = null;
	public $liChildClass = null;
	public $aParentClass = null;
	public $aChildClass = null;
	
	//public $childRelation = 'children';
	//public $parentField = 'parent_id';
	//public $isMany = true; // Множественный выбор включен по умолчанию, идентификация родительских элементов осуществляется по таблице
    
    public function init()
    {
        parent::init();
        return true;
    }
	
    public function run()
    {
        $data = $this->treeBuilder($this->data);
		return $this->buildMenuRecursive($data, $this->url, $this->parentFieldValue);
    }
	
	protected function buildMenuRecursive($data, $url = '/', $parentFieldValue = 0, $level = 0, $foolproof = 20)
    {
		$return = '';
		$aOptions = [];
		$liOptions = [];
		$ulOptions = [];
		
		if (isset($data[$parentFieldValue])) 
		{
			$li = '';
			if ($parentFieldValue == 0) 
			{
				if($this->ulParentClass) $ulOptions['class'] = $this->ulParentClass;
				if($this->liParentClass) $liOptions['class'] = $this->liParentClass;
				if($this->aParentClass) $aOptions['class'] = $this->aParentClass;
			} 
			else 
			{
				if($this->ulChildClass) $ulOptions['class'] = $this->ulChildClass;
				if($this->liChildClass) $liOptions['class'] = $this->liChildClass;
				if($this->aChildClass) $aOptions['class'] = $this->aChildClass;
			}
			
            foreach ($data[$parentFieldValue] as $element) 
			{
                $element->level = $level;
				$parentUrl = $url.'/'.$element->alias;
				
				$a = Html::a($element->{$this->nameField}, $url.'/'.$element->alias, $aOptions);
				
				$a .= $this->buildMenuRecursive($data, $parentUrl, $element->id, $level+1, $foolproof-1);
				$li .= Html::tag('li', $a, $liOptions);
				
            }
			$return .= Html::tag('ul', $li, $ulOptions);
        }
        return $return;
    }
}