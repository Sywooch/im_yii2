<?php
namespace app\modules\order\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\Order;
/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
	public $date_from;
    public $date_to;
	
    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['id', 'status', 'shipping', 'payment', 'type'], 'integer'],
            [['name', 'date', 'phone', 'email'], 'string'],
			[['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = Order::find()->orderBy(['date' => SORT_DESC]);
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
			'status' => $this->status,
			'shipping' => $this->shipping,
			'payment' => $this->payment,
			'type' => $this->type,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'phone', $this->phone])
			->andFilterWhere(['>=', 'date', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'date', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
			->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}