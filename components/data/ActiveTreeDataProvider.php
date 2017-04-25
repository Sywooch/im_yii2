<?php

namespace app\components\data;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Connection;
use yii\db\QueryInterface;
use yii\di\Instance;

class ActiveTreeDataProvider extends ActiveDataProvider
{
	public $childRelation = 'children';
	public $parentField = 'parent_id';
	public $isMany = true; // Множественный выбор включен по умолчанию, идентификация родительских элементов осуществляется по таблице
    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
		
        $query = clone $this->query;
				
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
		
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }
		
        $items = $query->all($this->db);
		
		if($this->isMany)
		{
			if($items)
			{
				$pre_return = [];
				foreach ($items as $value)
				{
					if($value->{$this->childRelation})
					{
						foreach($value->{$this->childRelation} as $item)
						{
							$pre_return[$item->id][] = $value;
						}
					}
					else
					{
						$pre_return[$value->{$this->parentField}][] = $value;
					}
				}
				$items = $this->buildRecursive($pre_return);
			}
		}
		else
		{
			if($items)
			{
				$pre_return = [];
				foreach ($items as $value) 
				{
					$pre_return[$value->{$this->parentField}][] = $value;
				}
				$items = $this->buildRecursive($pre_return);
			}
		}
        return $items;
    }

    /**
     * @inheritdoc
     */
    protected function prepareKeys($models)
    {
        $keys = [];
        if ($this->key !== null) {
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        } elseif ($this->query instanceof ActiveQueryInterface) {
            /* @var $class \yii\db\ActiveRecord */
            $class = $this->query->modelClass;
            $pks = $class::primaryKey();
            if (count($pks) === 1) {
                $pk = $pks[0];
                foreach ($models as $model) {
                    $keys[] = $model[$pk];
                }
            } else {
                foreach ($models as $model) {
                    $kk = [];
                    foreach ($pks as $pk) {
                        $kk[$pk] = $model[$pk];
                    }
                    $keys[] = $kk;
                }
            }

            return $keys;
        } else {
            return array_keys($models);
        }
    }

    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query;
        return (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
    }

    /**
     * @inheritdoc
     */
    public function setSort($value)
    {
        parent::setSort($value);
        if (($sort = $this->getSort()) !== false && $this->query instanceof ActiveQueryInterface) {
            /* @var $model Model */
            $model = new $this->query->modelClass;
            if (empty($sort->attributes)) {
                foreach ($model->attributes() as $attribute) {
                    $sort->attributes[$attribute] = [
                        'asc' => [$attribute => SORT_ASC],
                        'desc' => [$attribute => SORT_DESC],
                        'label' => $model->getAttributeLabel($attribute),
                    ];
                }
            } else {
                foreach ($sort->attributes as $attribute => $config) {
                    if (!isset($config['label'])) {
                        $sort->attributes[$attribute]['label'] = $model->getAttributeLabel($attribute);
                    }
                }
            }
        }
    }
	
	protected function buildRecursive(array $data, $parentId = 0, $level = 0, $foolproof = 20) 
	{
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