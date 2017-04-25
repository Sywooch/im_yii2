<?php

namespace app\modules\filter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\filter\models\Filter;

/**
 * PartnersSearch represents the model behind the search form about `app\models\Partners`.
 */
class FilterSearch extends Filter
{
	public $id;
	public $title;
	public $weight;
	public $status;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'status'], 'integer'],
            [['title'], 'safe']
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'FILTER_BACK_FORM_ID'),
			'title' => Yii::t('app', 'FILTER_BACK_FORM_TITLE'),
            'weight' => Yii::t('app', 'FILTER_BACK_FORM_WEIGHT'),
            'status' => Yii::t('app', 'FILTER_BACK_FORM_STATUS'),
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
        $query = Filter::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}