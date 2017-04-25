<?php

namespace app\modules\review\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\review\models\Review;

/**
 * PartnersSearch represents the model behind the search form about `app\models\Partners`.
 */
class ReviewSearch extends Review
{
	public $id;
	public $title;
	public $client_id;
	public $teaser;
	public $body;
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
            [['title', 'alias', 'client_id'], 'safe']
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
        $query = Review::find()->with('client'); // ->with('client') Жадная загрузка связи client 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'client_id' => $this->client_id,
			'weight' => $this->weight,
            'status' => $this->status,
			'alias' => $this->alias,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
