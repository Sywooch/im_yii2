<?php
namespace app\components\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;

class MenuTreeItems extends \app\components\widgets\Tree
{
    public $data = null;
	public $parentFieldValue = 0;
	public $nameField = 'title';
	public $currentUrl = null;
	public $isFull = true;
	
	public $activeClass = 'active';
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
		$this->isMany = false; // переключаем builder в "режим меню"
        return true;
    }
	
    public function run()
    {
        $data = $this->treeBuilder($this->data);
		return $this->buildMenuRecursive($data, $this->parentFieldValue);
    }
	
	protected function buildMenuRecursive($data, $parentFieldValue = 0, $level = 0, $foolproof = 20)
    {
		$return = '';
		
		if (isset($data[$parentFieldValue])) 
		{
			$li = '';
            foreach ($data[$parentFieldValue] as $element) 
			{
				$aOptions = [];
				$liOptions = [];
				$ulOptions = [];
				
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
				
				$urlArr = explode('/', $element->url);
				
				// Находим активный элемент и присваиваем ему "activeClass"
				if ($this->currentUrl && $this->currentUrl == $urlArr[1]) 
				{
					// "activeClass" для элемента "li" (закоментировать если не используется)
					if(isset($liOptions['class']))
					{
						$liOptions['class'] = $liOptions['class'].' '.$this->activeClass;
					}
					else
					{
						$liOptions['class'] = $this->activeClass;
					}
					
					// "activeClass" для элемента "a" (закоментировать если не используется)
					/* if(isset($aOptions['class']))
					{
						$aOptions['class'] = $aOptions['class'].' '.$this->activeClass;
					}
					else
					{
						$aOptions['class'] = $this->activeClass;
					} */
				} 
				
                $element->level = $level;
				$a = Html::a($element->{$this->nameField}, $element->url, $aOptions);
				
				$a .= $this->buildMenuRecursive($data, $element->id, $level+1, $foolproof-1);
				$li .= Html::tag('li', $a, $liOptions);
            }
			
			// Используется или не используется корневой элемент "ul"
			if($this->isFull || (!$this->isFull && $parentFieldValue))
			{
				$return .= Html::tag('ul', $li, $ulOptions);
			}
			else
			{
				$return .= $li;
			}
        }
        return $return;
    }
}