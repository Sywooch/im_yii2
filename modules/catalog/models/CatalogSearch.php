<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\components\data\ActiveTreeDataProvider;
use app\modules\catalog\models\Catalog;

/**
 * PortfolioSearch represents the model behind the search form about `app\modules\portfolio\models\Portfolio`.
 */
class CatalogSearch extends Catalog
{
	public $id;
	public $short_title;
	public $alias;
	public $weight;
	public $status;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'status'], 'integer'],
            [['short_title', 'alias'], 'safe'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Catalog::find()->where(['is_main' => 0])->with('children')->orderBy('weight'); // ->with('parent') Жадная загрузка связи parent ;
        $dataProvider = new ActiveTreeDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 100, // количество материалов на странице
			],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
			'weight' => $this->weight,
            'status' => $this->status,
			'alias' => $this->alias,
        ]);
		
		$query->andFilterWhere(['like', 'short_title', $this->short_title]);
        return $dataProvider;
    }
}