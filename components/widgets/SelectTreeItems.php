<?php
namespace app\components\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;

class SelectTreeItems extends \app\components\widgets\Tree
{
    public $data = NULL;
    public $model = NULL;
	
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
        if (!is_object($this->model)) {
            return false;
        }

		$return = '';
		$parents = [];
		
        $data = $this->treeBuilder($this->data);
		$items = $this->buildRecursive($data);
		
		if($items && !empty($items))
		{
			if($this->isMany && $this->model && isset($this->model->{$this->childRelation}) && $this->model->{$this->childRelation})
			{
				foreach($this->model->{$this->childRelation} as $children)
				{
					$parents[$children->id] = $children->id;
				}
			}
			else
			{
				if($this->model && $this->model->{$this->parentField})
				{
					$parents[$this->model->{$this->parentField}] = $this->model->{$this->parentField};
				}
			}
			
			foreach($items as $item)
			{
				$attrs = [];
				$attrs['value'] = $item->id;
				
				if(!$item->level) $attrs['style'] = 'font-weight:bold;';
				if(isset($parents[$item->id])) $attrs['selected'] = 'selected';
				if($this->model && $this->model->id == $item->id) $attrs['disabled'] = 'disabled';
				
				$text = str_repeat('--', $item->level).' '.$item->title;
				$return .= Html::tag('option', $text, $attrs);
			}
		}
		return $return;
    }
}