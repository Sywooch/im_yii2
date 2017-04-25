<?php
namespace app\modules\fav\models;

use app\modules\fav\interfaces\Fav as FavInterface;
use yii;

class Fav extends \yii\db\ActiveRecord implements FavInterface
{
    private $element = null;
    
    public function init()
    {
        $this->element = yii::$container->get('favElement');
    }
    
    public function my()
    {
        $query = new tools\FavQuery(get_called_class());
        return $query->my();
    }
    
    public function put(\app\modules\fav\interfaces\Element $elementModel)
    {
        $elementModel->hash = self::_generateHash($elementModel->model, $elementModel->price);

        $elementModel->link('fav', $this->my());

        if ($elementModel->validate() && $elementModel->save()) {
            return $elementModel;
        } else {
            throw new \Exception(current($elementModel->getFirstErrors()));
        }
    }
    
    public function getElements()
    {
        return $this->hasMany($this->element, ['fav_id' => 'id']);
    }
    
    public function getElement(\app\modules\fav\interfaces\FavElement $model)
    {
        return $this->getElements()->where(['hash' => $this->_generateHash(get_class($model), $model->getFavPrice()), 'item_id' => $model->getFavId()])->one();
    }
    
    public function getElementsByModel(\app\modules\fav\interfaces\FavElement $model)
    {
        return $this->getElements()->andWhere(['model' => get_class($model), 'item_id' => $model->getFavId()])->all();
    }
    
    public function getElementById($id)
    {
        return $this->getElements()->andWhere(['id' => $id])->one();
    }
    
    public function getCount()
    {
        return intval($this->getElements()->sum('count'));
    }
    
    public function getCost()
    {
        return $cost = $this->getElements()->sum('price*count');
    }
    
    public function truncate()
    {
        foreach($this->elements as $element) {
            $element->delete();
        }
        
        return $this;
    }

    public function rules()
    {
        return [
            [['created_time', 'user_id'], 'required', 'on' => 'create'],
            [['updated_time', 'created_time'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => yii::t('fav', 'ID'),
            'user_id' => yii::t('fav', 'User ID'),
            'created_time' => yii::t('fav', 'Created Time'),
            'updated_time' => yii::t('fav', 'Updated Time'),
        ];
    }
    
    public static function tableName()
    {
        return '{{%fav}}';
    }
    
    public function beforeDelete()
    {
        foreach ($this->elements as $elem) {
            $elem->delete();
        }
        
        return true;
    }
    
    private static function _generateHash($modelName, $price)
    {
        return md5($modelName.$price);
    }
}
