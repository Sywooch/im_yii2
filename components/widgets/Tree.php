<?php

namespace app\components\widgets;

class Tree extends \yii\base\Widget
{
	public $childRelation = 'children';
	public $parentField = 'parent_id';
	public $isMany = true; // Множественный выбор включен по умолчанию, идентификация родительских элементов осуществляется по таблице
	
	/**
     * @inheritdoc
     */
    protected function treeBuilder($items)
    {
		$return = [];
		
		if($this->isMany)
		{
			if($items)
			{
				foreach ($items as $value)
				{
					if($value->{$this->childRelation})
					{
						foreach($value->{$this->childRelation} as $item)
						{
							$return[$item->id][] = $value;
						}
					}
					else
					{
						$return[$value->{$this->parentField}][] = $value;
					}
				}
			}
		}
		else
		{
			if($items)
			{
				foreach ($items as $value) 
				{
					$return[$value->{$this->parentField}][] = $value;
				}
			}
		}
        return $return;
    }
	
	protected function buildRecursive(array $data, $parentId = 0, $level = 0, $foolproof = 20) {
        $return = [];
		
		if (isset($data[$parentId])) 
		{
            foreach ($data[$parentId] as $element) 
			{
                $element->level = $level;
				$return[] = $element;
				$children = $this->buildRecursive($data, $element->id, $level+1, $foolproof-1);
				if ($children) 
				{
					$return = array_merge($return, $children);
				} 
            }
        }
        return $return;
    }
}