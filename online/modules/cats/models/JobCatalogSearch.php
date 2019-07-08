<?php

namespace app\modules\cats\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cats\models\JobCatalog;

/**
 * JobCatalogSearch represents the model behind the search form about `app\modules\cats\models\JobCatalog`.
 */
class JobCatalogSearch extends JobCatalog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'organization_id'], 'integer'],
            [['name', 'description', 'notes', 'open_date', 'close_date', 'url', 'status', 'datetime', 'tag'], 'safe'],
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
        $query = JobCatalog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'open_date' => $this->open_date,
            'close_date' => $this->close_date,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        return $dataProvider;
    }
}
