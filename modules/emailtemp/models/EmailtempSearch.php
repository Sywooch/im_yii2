<?php

namespace app\modules\emailtemp\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\emailtemp\models\Emailtemp;

/**
 * PartnersSearch represents the model behind the search form about `app\models\Partners`.
 */
class EmailtempSearch extends Emailtemp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['act'], 'integer'],
            [['title', 'subject'], 'safe'],
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
        $query = Emailtemp::find();

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
			'act' => $this->act,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'subject', $this->subject]);

        return $dataProvider;
    }
}
