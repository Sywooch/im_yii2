<?php
namespace app\modules\article\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Article;

use app\modules\article\Module;

/**
 * PartnersSearch represents the model behind the search form about `app\models\Partners`.
 */
class ArticleSearch extends Article
{
	public $id;
	public $short_title;
	public $title;
	public $date;
	public $teaser;
	public $body;
	public $alias;
	public $weight;
	public $status;
	public $date_from;
    public $date_to;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'status'], 'integer'],
            [['title', 'short_title', 'alias', 'date'], 'safe'],
			[['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ARTICLE_BACK_FORM_ID'),
            'date' => Module::t('module', 'ARTICLE_BACK_FORM_DATE'),
			'date_from' => Module::t('module', 'ARTICLE_BACK_FORM_DATE_FROM'),
			'date_to' => Module::t('module', 'ARTICLE_BACK_FORM_DATE_TO'),
			'title' => Module::t('module', 'ARTICLE_BACK_FORM_TITLE'),
			'short_title' => Module::t('module', 'ARTICLE_BACK_FORM_SHORT_TITLE'),
			'imageFile' => Module::t('module', 'ARTICLE_BACK_FORM_FILE'),
            'teaser' => Module::t('module', 'ARTICLE_BACK_FORM_TEASER'),
            'body' => Module::t('module', 'ARTICLE_BACK_FORM_BODY'),
            'alias' => Module::t('module', 'ARTICLE_BACK_FORM_ALIAS'),
            'weight' => Module::t('module', 'ARTICLE_BACK_FORM_WEIGHT'),
            'status' => Module::t('module', 'ARTICLE_BACK_FORM_STATUS'),
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
        $query = Article::find()->where(['is_main' => 0]);
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
        $query->andFilterWhere(['like', 'short_title', $this->short_title])
			->andFilterWhere(['>=', 'date', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'date', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
			->andFilterWhere(['like', 'alias', $this->alias]);
        return $dataProvider;
    }
}