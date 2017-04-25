<?php

namespace app\components\widgets;

class CatalogChildItems extends \app\components\widgets\Tree
{
    public $data = NULL;
	public $parentFieldValue = 0;
	public $url = '/';
	
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
		
		if (isset($data[$this->parentFieldValue])) 
		{
			return $this->render('catalog-child-items', ['catalog' => $data[$this->parentFieldValue], 'url' => $this->url]);
        }
		else
		{
			return null;
		}
    }
}