<?php

namespace app\modules\infoblock\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\infoblock\models\Infoblock;

/**
 * PartnersSearch represents the model behind the search form about `app\models\Partners`.
 */
class InfoblockSearch extends Infoblock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'status'], 'integer'],
            [['title', 'body', 'alias'], 'safe'],
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
        $query = Infoblock::find();

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
            'id' => $this->id,
            'weight' => $this->weight,
            'status' => $this->status,
			'alias' => $this->alias,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
