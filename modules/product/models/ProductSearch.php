<?php
namespace app\modules\product\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\product\models\Product;
/**
 * ProductSearch represents the model behind the search form about `app\modules\product\models\Product`.
 */
class ProductSearch extends Product
{
	public $id;
	public $title;
	public $alias;
	public $weight;
	public $is_not;
	public $status;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'status', 'is_not'], 'integer'],
            [['title', 'alias'], 'safe'],
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
        $query = Product::find()->where(['is_main' => 0]); // ->with('filter') Жадная загрузка связи filter ;
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
			'weight' => $this->weight,
			'is_not' => $this->is_not,
            'status' => $this->status,
			'alias' => $this->alias,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'alias', $this->alias]);
        return $dataProvider;
    }
}