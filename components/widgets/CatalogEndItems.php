<?php
namespace app\components\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use app\modules\file\components\Img;
use app\components\helpers\Text;
use yii;

class CatalogEndItems extends \app\components\widgets\Tree
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
			return $this->render('catalog-end-items', ['catalog' => $data[$this->parentFieldValue], 'url' => $this->url]);
        }
		else
		{
			return null;
		}
    }
}